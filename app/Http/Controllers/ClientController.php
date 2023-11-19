<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use App\Http\Requests\StoreClientRequest;
use App\Services\ClientService;
class ClientController extends Controller
{
    protected $clientService;
    public function __construct(ClientService $clientService)
    {
        $this->clientService = $clientService;
    }

    public function index(Request $request)
    {
        $clients = $this->clientService->clients($request->view_deleted);
        return view('clients.index', compact('clients'));
    }

    public function create()
    {
        return view('clients.create');
    }

    public function store(StoreClientRequest $request)
    {
        $this->clientService->upsert($request->validated());
        return redirect()->route('admin.clients.index');
    }

    public function show(Client $client)
    {
        //
    }

    public function edit(Client $client)
    {
        return view('clients.edit', compact('client'));
    }

    public function update(StoreClientRequest $request, Client $client)
    {
        $this->clientService->upsert($request->validated(), $client->id);
        return redirect()->route('admin.clients.index');
    }

    public function destroy(Client $client)
    {
        $client->delete();
        return redirect()->route('admin.clients.index');
    }

    public function restore($id)
    {
        $this->clientService->restore($id);
        return back();
    }

    public function restoreAll() {
        $this->clientService->restoreAll();
        return back();
    }

    public function forceDelete($id)
    {
        $this->clientService->forceDelete($id);
        return back();
    }

    public function forceDeleteAll()
    {
        $this->clientService->forceDeleteAll();
        return back();
    }
}
