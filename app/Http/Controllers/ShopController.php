<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class ShopController extends Controller
{
    public function index()
    {
        $shops = auth()->user()->shops;
        return response()->json($shops);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'logo' => 'nullable|string',
            'banner' => 'nullable|string',
        ]);

        $shop = Shop::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'logo' => $request->logo,
            'banner' => $request->banner,
        ]);

        // Attach the user as the owner
        $shop->users()->attach(auth()->id(), ['role' => 'owner']);

        return response()->json($shop, 201);
    }

    public function show(Shop $shop)
    {
        $this->authorize('view', $shop);
        return response()->json($shop);
    }

    public function update(Request $request, Shop $shop)
    {
        $this->authorize('update', $shop);

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'logo' => 'nullable|string',
            'banner' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $shop->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'logo' => $request->logo,
            'banner' => $request->banner,
            'is_active' => $request->is_active,
        ]);

        return response()->json($shop);
    }

    public function destroy(Shop $shop)
    {
        $this->authorize('delete', $shop);
        $shop->delete();
        return response()->json(null, 204);
    }
} 