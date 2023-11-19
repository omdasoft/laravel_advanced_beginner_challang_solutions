<?php
namespace App\Services;
use App\Models\Project;
use App\Models\User;
use App\Models\Client;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
class ProjectService
{
    public function projects(string $view_deleted = null): LengthAwarePaginator
    {
        $qry = Project::with(['user', 'client'])->latest();
        if($view_deleted) 
        {
            $qry->onlyTrashed();
        }
        $projects = $qry->paginate(15);
        return $projects;
    }

    public function upsert(array $data, int $id = null): Project
    {
        return Project::updateOrCreate(['id' => $id], $data);
    }

    public function users(): Collection
    {
        return User::exceptCurrentUser()->latest()->get();
    }

    public function clients(): Collection
    {
        return Client::latest()->get();
    }

    public function forceDelete(int $id): bool
    {
        Project::withTrashed()->findOrFail($id)->forceDelete();
        return true;
    }

    public function forceDeleteAll(): bool
    {
        Project::onlyTrashed()->get()->each->forceDelete();
        return true;
    }

    public function restore(int $id): bool
    {
        Project::withTrashed()->findOrFail($id)->restore();
        return true;
    }

    public function restoreAll(): bool
    {
        Project::onlyTrashed()->get()->each->restore();
        return true;
    }
}