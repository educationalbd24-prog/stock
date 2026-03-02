<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\ShopManager;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $gear = Category::query()->create(['name' => 'Travel Gear', 'slug' => 'travel-gear']);
        $home = Category::query()->create(['name' => 'Home Office', 'slug' => 'home-office']);

        Product::query()->insert([
            [
                'category_id' => $gear->id,
                'name' => 'Explorer Backpack',
                'slug' => 'explorer-backpack',
                'description' => 'Water-resistant backpack with laptop compartment.',
                'price' => 79.00,
                'image_url' => 'https://images.unsplash.com/photo-1581605405669-fcdf81165afa?auto=format&fit=crop&w=1000&q=80',
                'inventory' => 120,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'category_id' => $home->id,
                'name' => 'Focus Desk Lamp',
                'slug' => 'focus-desk-lamp',
                'description' => 'Dimmable LED lamp with USB-C charging base.',
                'price' => 49.00,
                'image_url' => 'https://images.unsplash.com/photo-1513506003901-1e6a229e2d15?auto=format&fit=crop&w=1000&q=80',
                'inventory' => 8,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);

        $manager = ShopManager::query()->create([
            'name' => 'Rahim Uddin',
            'email' => 'manager@stock.local',
            'phone' => '01700000000',
            'is_active' => true
        ]);

        Order::query()->create([
            'manager_id' => $manager->id,
            'email' => 'customer@example.com',
            'status' => 'paid',
            'total_amount' => 79.00
        ]);
    }
}
