<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\User;
use App\Models\Project;
use App\Models\Client;
use App\Http\Requests\StoreTaskRequest;
use App\Services\TaskService;
class TaskController extends Controller
{
    protected $taskService;
    public function __construct(TaskService $taskService)
    {
        $this->taskService = $taskService;
    }

    public function index(Request $request)
    {
        $tasks = $this->taskService->index($request['view_deleted']);
        return view('tasks.index', compact('tasks'));
    }

    public function create()
    {
        $users = $this->taskService->users();
        $clients = $this->taskService->clients();
        $projects = $this->taskService->projects();
        return view('tasks.create', compact('users', 'projects', 'clients'));
    }

    public function store(StoreTaskRequest $request)
    {
        $task = $this->taskService->upsert($request->validated());
        return redirect()->route('admin.tasks.index');
    }

    public function show(Task $task)
    {
        return view('tasks.show', compact('task'));
    }

    public function edit(Task $task)
    {
        $users = $this->taskService->users();
        $clients = $this->taskService->clients();
        $projects = $this->taskService->projects();
        return view('tasks.edit', compact('task', 'users', 'clients', 'projects'));
    }

    public function update(StoreTaskRequest $request, $id)
    {
       $task = $this->taskService->upsert($request->validated(), $id);
       return redirect()->route('admin.tasks.index');
    }

    public function destroy(Task $task)
    {
        $task->delete();
        return redirect()->route('admin.tasks.index');
    }

    public function forceDelete(int $id)
    {
        $this->taskService->forceDelete($id);
        return back();
    }

    public function forceDeleteAll()
    {
        $this->taskService->forceDeleteAll();
        return back();
    }

    public function restore(int $id)
    {
        $this->taskService->restore($id);
        return back();
    }

    public function restoreAll()
    {
        $this->taskService->restoreAll();
        return back();
    }
}
