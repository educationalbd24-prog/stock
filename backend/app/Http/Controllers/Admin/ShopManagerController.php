<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ShopManager;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ShopManagerController extends Controller
{
    public function index(): View
    {
        return view('admin.managers', [
            'managers' => ShopManager::query()->latest()->paginate(10)
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:shop_managers,email'],
            'phone' => ['nullable', 'string', 'max:30']
        ]);

        ShopManager::query()->create([
            ...$validated,
            'is_active' => true
        ]);

        return redirect()->route('admin.managers.index')->with('status', 'Shop manager created.');
    }

    public function update(Request $request, ShopManager $manager): RedirectResponse
    {
        $validated = $request->validate([
            'is_active' => ['required', 'boolean']
        ]);

        $manager->update($validated);

        return redirect()->route('admin.managers.index')->with('status', 'Manager status updated.');
    }
}
