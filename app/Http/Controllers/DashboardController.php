<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        if(isAdminUser()) {
            $total['total_user'] = User::exceptCurrentUser()->count();
            $total['total_project'] = Project::count();
            $total['total_client'] = Client::count();
            $total['total_task'] = Task::count();
            $latest_projects = Project::with(['user', 'client'])->latest()->limit(5)->get();
            $latest_tasks = Task::with(['user', 'client', 'project'])->latest()->limit(5)->get();  
            
            return view('dashboard', compact('total', 'latest_projects', 'latest_tasks'));  
        }

        $userId = auth()->user()->id;
        $total['total_project'] = Project::where('user_id', $userId)->count();
        $total['total_task'] = Task::where('user_id', $userId)->count();
        $latest_projects = Project::with(['user', 'client'])->where('user_id', $userId)->latest()->limit(5)->get();
        $latest_tasks = Task::with(['user', 'client', 'project'])->where('user_id', $userId)->latest()->limit(5)->get();    

        return view('dashboard', compact('total', 'latest_projects', 'latest_tasks'));
    }
}
