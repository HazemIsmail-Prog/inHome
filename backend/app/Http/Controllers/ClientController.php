<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;

class ClientController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->user()->hasPermission('clients_view')) {
            return response()->json(['message' => 'unauthorized'], 403);
        }
        $clients = Client::query()
            ->orderBy('id', 'desc')
            ->when($request->search, function ($query, $search) {
                $query->whereAny(['name', 'phone', 'address', 'notes'], 'like', '%' . $search . '%');
            })
            ->paginate(20);
        return response()->json($clients);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);
        $validated['created_by'] = $request->user()->id;
        $client = Client::create($validated);
        return response()->json($client);
    }

    public function update(Client $client, Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);
        $client->update($validated);
        return response()->json($client);
    }

    public function destroy(Client $client)
    {
        $client->delete();
        return response()->json($client);
    }
}
