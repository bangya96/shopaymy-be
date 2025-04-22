<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Shop;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class PageController extends Controller
{
    public function index(Shop $shop)
    {
        $this->authorize('view', $shop);
        $pages = $shop->pages;
        return response()->json($pages);
    }

    public function store(Request $request, Shop $shop)
    {
        $this->authorize('update', $shop);

        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
        ]);

        $page = $shop->pages()->create([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'content' => $request->content,
            'meta_title' => $request->meta_title,
            'meta_description' => $request->meta_description,
        ]);

        return response()->json($page, 201);
    }

    public function show(Shop $shop, Page $page)
    {
        $this->authorize('view', $shop);
        return response()->json($page);
    }

    public function update(Request $request, Shop $shop, Page $page)
    {
        $this->authorize('update', $shop);

        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $page->update([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'content' => $request->content,
            'meta_title' => $request->meta_title,
            'meta_description' => $request->meta_description,
            'is_active' => $request->is_active,
        ]);

        return response()->json($page);
    }

    public function destroy(Shop $shop, Page $page)
    {
        $this->authorize('update', $shop);
        $page->delete();
        return response()->json(null, 204);
    }
} 