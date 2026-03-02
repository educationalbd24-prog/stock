<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\ShopManager;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class PosController extends Controller
{
    public function index(): View
    {
        return view('admin.pos', [
            'products' => Product::query()->orderBy('name')->get(),
            'managers' => ShopManager::query()->where('is_active', true)->orderBy('name')->get()
        ]);
    }

    public function checkout(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'manager_id' => ['required', 'exists:shop_managers,id'],
            'email' => ['required', 'email'],
            'items' => ['required', 'array', 'min:1'],
            'items.*.product_id' => ['nullable', 'integer', 'exists:products,id'],
            'items.*.quantity' => ['nullable', 'integer', 'min:1']
        ]);

        $items = collect($validated['items'])
            ->filter(fn (array $item): bool => !empty($item['product_id']) && !empty($item['quantity']))
            ->values();

        if ($items->isEmpty()) {
            throw ValidationException::withMessages(['items' => 'At least one POS item is required.']);
        }

        DB::transaction(function () use ($validated, $items): void {
            $productIds = $items->pluck('product_id');
            $products = Product::query()->whereIn('id', $productIds)->lockForUpdate()->get()->keyBy('id');

            $total = 0;
            $order = Order::query()->create([
                'manager_id' => $validated['manager_id'],
                'email' => $validated['email'],
                'status' => 'paid',
                'total_amount' => 0
            ]);

            foreach ($items as $item) {
                $product = $products[$item['product_id']];

                if ($product->inventory < $item['quantity']) {
                    throw ValidationException::withMessages([
                        'items' => "Insufficient inventory for {$product->name}."
                    ]);
                }

                $lineTotal = $product->price * $item['quantity'];
                $total += $lineTotal;

                $order->items()->create([
                    'product_id' => $product->id,
                    'quantity' => $item['quantity'],
                    'unit_price' => $product->price,
                    'line_total' => $lineTotal
                ]);

                $product->decrement('inventory', $item['quantity']);
            }

            $order->update(['total_amount' => $total]);
        });

        return redirect()->route('admin.pos.index')->with('status', 'POS checkout completed successfully.');
    }
}
