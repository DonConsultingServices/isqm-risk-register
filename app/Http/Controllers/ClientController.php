<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ClientController extends Controller
{
    public function index(): View
    {
        return view('clients.index', [
            'clients' => Client::orderBy('name')->paginate(20),
        ]);
    }

    public function create(): View
    {
        return view('clients.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'industry' => 'nullable|string|max:255',
            'email' => 'nullable|email',
            'phone' => 'nullable|string|max:50',
        ]);
        Client::create($data);
        return redirect()->route('clients.index')->with('status', 'Client created');
    }

    public function edit(Client $client): View
    {
        return view('clients.edit', compact('client'));
    }

    public function update(Request $request, Client $client): RedirectResponse
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'industry' => 'nullable|string|max:255',             
            'email' => 'nullable|email',
            'phone' => 'nullable|string|max:50',
        ]);
        $client->update($data);
        return redirect()->route('clients.index')->with('status', 'Client updated');
    }

    public function destroy(Client $client): RedirectResponse
    {
        $client->delete();
        return back()->with('status', 'Client deleted');
    } 
}


