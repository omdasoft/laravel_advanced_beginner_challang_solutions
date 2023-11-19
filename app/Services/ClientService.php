<?php
namespace App\Services;
use App\Models\Client;
use Illuminate\Pagination\LengthAwarePaginator;

class ClientService {
    const PER_PAGE = 15;
    public function __construct(){}

    public function clients(string $view_deleted = null): LengthAwarePaginator
    {
        $clients = Client::latest();

        if($view_deleted) {
            $clients->onlyTrashed();
        }

       return  $clients->paginate(self::PER_PAGE);
    }

    public function upsert(array $data, int $id = null): Client
    {
        return Client::updateOrCreate(['id' => $id], $data);
    }

    public function restore(int $id): bool
    {
        Client::withTrashed()->findOrFail($id)->restore();
        return true;
    }

    public function restoreAll(): bool
    {
        Client::onlyTrashed()->restore();
        return true;
    }

    public function forceDelete(int $id): bool
    {
        Client::withTrashed()->findOrFail($id)->forceDelete();
        return true;
    }

    public function forceDeleteAll(): bool
    {
        Client::onlyTrashed()->get()->each->forceDelete();
        return true;
    }
}