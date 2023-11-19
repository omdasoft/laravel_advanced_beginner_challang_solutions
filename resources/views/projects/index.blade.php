@extends('layouts.dashboard') 
@section('content')
<div class="row">
    <div class="col-md-12 d-flex">
        <div class="card flex-fill">
            <div class="card-header d-flex justify-content-between">
                <h5 class="card-title mb-0 mr-2">Projects</h5>
                <a href="{{ route('admin.projects.create')}}" class="btn btn-default">
                    <i class="align-middle me-2" data-feather="plus-square"></i> 
                    <span class="align-middle">Add</span>
                </a>
            </div>
            <div class="card-body">
                @if(request()->has('view_deleted'))
                    <a href="{{ route('admin.projects.index') }}" class="btn btn-info">View All Projects</a>
                    <a href="{{ route('admin.projects.restore.all') }}" class="btn btn-success">
                            <i class="align-middle" data-feather="rotate-ccw"></i>
                            <span class="align-middle">Restore All</span>
                        </a>
                    <a href="{{ route('admin.projects.force_delete.all') }}" class="btn btn-danger" onclick="return confirm('Are you sure want to delete all the trashed records permanently?')">
                            <i class="align-middle" data-feather="x"></i>
                            <span class="align-middle">Force Delete All</span>
                        </a> 
                @else 
                    @if(deleted_records_count('projects'))
                        <a href="{{ route('admin.projects.index', ['view_deleted' => 'DeletedRecords']) }}" class="btn btn-primary">View Delete Records ({{ deleted_records_count('projects') }})</a>                
                    @endif 
                @endif
                <table class="table table-hover my-0">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Dateline</th>
                            <th>Status</th>
                            <th>User Name</th>
                            <th>Client Name</th>
                            <th class="d-none d-xl-table-cell">Created Date</th>
                            <th>#</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($projects as $project)
                        <tr>
                            <td>{{ substr($project->title, 0, 35) }}</td>
                            <td>{{ $project->dateline }}</td>
                            <td>                            
                                <span class="badge {{ getStatusColorClass($project->status) }}">{{ $project->status }}</span>
                            </td>
                            <td>{{ $project->user ? $project->user->first_name : '' }}</td>
                            <td>{{ $project->client ? $project->client->contact_name : '' }}</td>
                            <td>{{ $project->created_at->format('Y-m-d') }}</td>
                            <td>
                                <div class="d-flex justify-content-between buttons-groups">
                                    @if(request()->has('view_deleted'))
                                        <a href="{{ route('admin.projects.restore', $project->id) }}" class="btn btn-success">
                                                    <i class="align-middle" data-feather="rotate-ccw"></i>
                                                    <span class="align-middle">restore</span>
                                            </a>
                                        <a href="{{ route('admin.projects.force_delete', $project->id) }}" class="btn btn-danger" onclick="return confirm('Are you sure want to delete this record permanently?')">
                                                <i class="align-middle" data-feather="x"></i>
                                                <span class="align-middle">force delete</span>
                                            </a> @else
                                        <a href="{{ route('admin.projects.edit', $project)}}" class="btn btn-warning">
                                                <i class="align-middle" data-feather="edit"></i> 
                                                <span class="align-middle">edit</span>
                                            </a>

                                        <form method="post" action="{{ route('admin.projects.destroy', $project) }}">
                                            @method('DELETE') @csrf
                                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure want to delete?')">
                                                        <i class="align-middle" data-feather="delete"></i> 
                                                        <span class="align-middle">delete</span>
                                                    </button>
                                        </form>

                                        <a href="{{ route('admin.projects.show', $project)}}" class="btn btn-success">
                                                    <i class="align-middle" data-feather="eye"></i> 
                                                    <span class="align-middle">view</span>
                                            </a> 
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9">No Data Found</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="mt-2">
                    {{ $projects->links()}}
                </div>
            </div>
        </div>
    </div>
@endsection