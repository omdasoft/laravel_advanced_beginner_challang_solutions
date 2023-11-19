@extends('layouts.dashboard') 
@section('content')
<h1 class="h3 mb-3">Dashboard <strong>Statistics</strong></h1>
<div class="row">
    <div class="col-xl-12 col-xxl-12 d-flex">
        <div class="w-100">
            <div class="row">
                <div class="col-sm-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col mt-0">
                                    <h5 class="card-title">Users</h5>
                                </div>

                                <div class="col-auto">
                                    <div class="stat text-primary">
                                        <i class="align-middle" data-feather="users"></i>
                                    </div>
                                </div>
                            </div>
                            <h1 class="mt-1 mb-3">{{ $total['total_user'] }}</h1>
                        </div>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col mt-0">
                                    <h5 class="card-title">Clients</h5>
                                </div>

                                <div class="col-auto">
                                    <div class="stat text-primary">
                                        <i class="align-middle" data-feather="credit-card"></i>
                                    </div>
                                </div>
                            </div>
                            <h1 class="mt-1 mb-3">{{ $total['total_client'] }}</h1>
                        </div>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col mt-0">
                                    <h5 class="card-title">Projects</h5>
                                </div>

                                <div class="col-auto">
                                    <div class="stat text-primary">
                                        <i class="align-middle" data-feather="dollar-sign"></i>
                                    </div>
                                </div>
                            </div>
                            <h1 class="mt-1 mb-3">{{ $total['total_project'] }}</h1>
                        </div>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col mt-0">
                                    <h5 class="card-title">Tasks</h5>
                                </div>

                                <div class="col-auto">
                                    <div class="stat text-primary">
                                        <i class="align-middle " data-feather="list"></i>
                                    </div>
                                </div>
                            </div>
                            <h1 class="mt-1 mb-3">{{ $total['total_task'] }}</h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card flex-fill">
            <div class="card-header">
                <h5 class="card-title mb-0">Latest Projects</h5>
            </div>
            <table class="table table-hover my-0">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Dateline</th>
                        <th>Status</th>
                        <th class="d-none d-xl-table-cell">User Name</th>
                        <th class="d-none d-xl-table-cell">Client Name</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($latest_projects as $project)
                    <tr>
                        <td>{{ substr($project->title, 0, 40) }}</td>
                        <td class="d-none d-xl-table-cell">{{ $project->dateline }}</td>
                        <td class="d-none d-xl-table-cell">
                            <span class="badge {{ getStatusColorClass($project->status) }}">{{ $project->status }}</span>
                        </td>
                        <td>{{ $project->user ? $project->user->first_name : ''}}</td>
                        <td class="d-none d-md-table-cell">{{ $project->client ? $project->client->contact_name : '' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5">No Projects</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card flex-fill">
            <div class="card-header">
                <h5 class="card-title mb-0">Latest Tasks</h5>
            </div>
            <table class="table table-hover my-0">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Dateline</th>
                        <th>Status</th>
                        <th>Project</th>
                        <th class="d-none d-xl-table-cell">User Name</th>
                        <th class="d-none d-xl-table-cell">Client Name</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($latest_tasks as $task)
                    <tr>
                        <td>{{ substr($task->title, 0, 40) }}</td>
                        <td class="d-none d-xl-table-cell">{{ $task->dateline }}</td>
                        <td class="d-none d-xl-table-cell">
                            <span class="badge {{ getStatusColorClass($task->status) }}">{{ $task->status }}</span>
                        </td>
                        <td>{{ substr($task->project->title, 0, 40) }}</td>
                        <td>{{ $task->user ? $task->user->first_name : ''}}</td>
                        <td class="d-none d-md-table-cell">{{ $task->client ? $task->client->contact_name : '' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5">No Projects</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection