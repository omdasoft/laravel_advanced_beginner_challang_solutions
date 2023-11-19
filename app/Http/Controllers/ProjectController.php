<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use App\Services\ProjectService;
use App\Http\Requests\StoreProjectRequest;
use App\Services\UserService;
class ProjectController extends Controller
{
    protected $projectService;

    public function __construct(ProjectService $projectService)
    {
        $this->projectService = $projectService;
    }

    public function index(Request $request)
    {
        $projects = $this->projectService->projects($request->view_deleted);
        return view('projects.index', compact('projects'));
    }

    public function create()
    {
        $users = $this->projectService->users();
        $clients = $this->projectService->clients();

        return view('projects.create', compact(['users', 'clients']));
    }

    public function store(StoreProjectRequest $request)
    {
        $this->projectService->upsert($request->validated());
        return redirect()->route('admin.projects.index');
    }

    public function show(Project $project)
    {
       return view('projects.show', compact('project')); 
    }

    public function edit(Project $project)
    {
        $users = $this->projectService->users();
        $clients = $this->projectService->clients();
        return view('projects.edit', compact(['project', 'users', 'clients']));
    }

    public function update(StoreProjectRequest $request, Project $project)
    {
        $this->projectService->upsert($request->validated(), $project->id);
        return redirect()->route('admin.projects.index');
    }

    public function destroy(Project $project)
    {
        $project->delete();
        return redirect()->route('admin.projects.index');
    }

    public function restore($id)
    {
        $this->projectService->restore($id);
        return back();
    }

    public function restoreAll()
    {
        $this->projectService->restoreAll();
        return back();
    }

    public function forceDelete($id)
    {
        $this->projectService->forceDelete($id);
        return back();
    }

    public function forceDeleteAll()
    {
        $this->projectService->forceDeleteAll();
        return back();
    }
}
