<?php
namespace App\Services;

use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\User;
use App\Models\Task;
use App\Models\Project;
use App\Models\Client;
use Illuminate\Database\Eloquent\Collection;
class TaskService {
    const PER_PAGE = 15;

    public function index(string $view_deleted = null): LengthAwarePaginator
    {
        $tasks = Task::with(['user', 'client', 'project'])->latest();
        if($view_deleted) {
            $tasks->onlyTrashed();
        }

        return $tasks->paginate(self::PER_PAGE);
    }

    public function users(): Collection
    {
        return User::latest()->get();
    }

    public function projects(): Collection
    {
        return Project::latest()->get();
    }

    public function clients(): Collection
    {
        return Client::latest()->get();
    }

    public function upsert(array $data, $id = null): Task
    {
        return Task::updateOrCreate(['id' => $id], $data);
    }

    public function forceDelete(int $id): bool
    {
        Task::withTrashed()->findOrFail($id)->forceDelete();
        return true;
    }

    public function forceDeleteAll(): bool 
    {
        Task::onlyTrashed()->get()->each->forceDelete();
        return true;
    }

    public function restore(int $id): bool
    {
        Task::withTrashed()->findOrFail($id)->restore();
        return true;
    }

    public function restoreAll(): bool
    {
        Task::onlyTrashed()->get()->each->restore();
        return true;
    }
}