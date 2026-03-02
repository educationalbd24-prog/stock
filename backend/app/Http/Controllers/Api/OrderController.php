<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'manager_id' => ['nullable', 'exists:shop_managers,id'],
            'email' => ['required', 'email'],
            'items' => ['required', 'array', 'min:1'],
            'items.*.product_id' => ['required', 'integer', 'exists:products,id'],
            'items.*.quantity' => ['required', 'integer', 'min:1']
        ]);

        $order = DB::transaction(function () use ($validated): Order {
            $productIds = collect($validated['items'])->pluck('product_id');
            $products = Product::query()->whereIn('id', $productIds)->get()->keyBy('id');

            $total = 0;
            $order = Order::query()->create([
                'manager_id' => $validated['manager_id'] ?? null,
                'email' => $validated['email'],
                'status' => 'pending',
                'total_amount' => 0
            ]);

            foreach ($validated['items'] as $item) {
                $product = $products[$item['product_id']];
                $lineTotal = $product->price * $item['quantity'];
                $total += $lineTotal;

                $order->items()->create([
                    'product_id' => $product->id,
                    'quantity' => $item['quantity'],
                    'unit_price' => $product->price,
                    'line_total' => $lineTotal
                ]);
            }

            $order->update(['total_amount' => $total]);

            return $order->load(['items.product:id,name', 'manager:id,name']);
        });

        return response()->json([
            'message' => 'Order created successfully.',
            'data' => $order
        ], 201);
    }
}
