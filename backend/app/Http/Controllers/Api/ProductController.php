<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\JsonResponse;

class ProductController extends Controller
{
    public function index(): JsonResponse
    {
        $products = Product::query()
            ->with('category:id,name,slug')
            ->latest()
            ->get([
                'id',
                'category_id',
                'name',
                'slug',
                'description',
                'price',
                'image_url'
            ]);

        return response()->json(['data' => $products]);
    }
}
