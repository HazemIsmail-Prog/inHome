<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Store;

class StoreController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->user()->hasPermission('stores_view')) {
            return response()->json(['message' => 'unauthorized'], 403);
        }
        $stores = Store::query()
            ->orderBy('id', 'desc')
            ->when($request->search, function ($query, $search) {
                $query->whereAny(['name'], 'like', '%' . $search . '%');
            })
            ->paginate(20);
        return response()->json($stores);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:stores,name',
        ]);
        $validated['created_by'] = $request->user()->id;
        $store = Store::create($validated);
        return response()->json($store);
    }

    public function update(Store $store, Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:stores,name,' . $store->id,
        ]);
        $store->update($validated);
        return response()->json($store);
    }

    public function destroy(Store $store)
    {
        $store->delete();
        return response()->json($store);
    }
}
