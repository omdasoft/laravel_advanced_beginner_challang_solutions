@extends('layouts.dashboard') 
@section('content')
<div class="row">
    <div class="col-md-12 d-flex">
        <div class="card flex-fill">
            <div class="card-header d-flex justify-content-between">
                <h5 class="card-title mb-0 mr-2">Users</h5>
                <a href="{{ route('admin.users.create')}}" class="btn btn-default">
                    <i class="align-middle me-2" data-feather="plus-square"></i> 
                    <span class="align-middle">Add</span>
                </a>
            </div>
            <div class="card-body">
                @if(request()->has('view_deleted'))
                <a href="{{ route('admin.users.index') }}" class="btn btn-info">View All Users</a>
                <a href="{{ route('admin.users.restore.all') }}" class="btn btn-success">
                        <i class="align-middle" data-feather="rotate-ccw"></i>
                        <span class="align-middle">Restore All</span>
                    </a>
                <a href="{{ route('admin.users.force_delete.all') }}" class="btn btn-danger" onclick="return confirm('Are you sure want to delete all the trashed records permanently?')">
                        <i class="align-middle" data-feather="x"></i>
                        <span class="align-middle">Force Delete All</span>
                    </a> @else @if(deleted_records_count('users'))
                <a href="{{ route('admin.users.index', ['view_deleted' => 'DeletedRecords']) }}" class="btn btn-primary">View Delete Records ({{ deleted_records_count('users') }})</a>                @endif @endif
                <table class="table table-hover my-0">
                    <thead>
                        <tr>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Role</th>
                            <th class="d-none d-xl-table-cell">Created Date</th>
                            <th>#</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                        <tr>
                            <td>{{ $user->first_name }}</td>
                            <td>{{ $user->last_name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->phone_number }}</td>
                            <td>
                                @foreach($user->roles as $role)
                                    <span class="badge bg-info"> {{ $role->name }}</span> 
                                @endforeach
                            </td>
                            <td>{{ $user->created_at->format('Y-m-d') }}</td>
                            <td>
                                <div class="d-flex justify-content-between buttons-groups">
                                    @if(request()->has('view_deleted'))
                                        <a href="{{ route('admin.users.restore', $user->id) }}" class="btn btn-success">
                                                            <i class="align-middle" data-feather="rotate-ccw"></i>
                                                            <span class="align-middle">restore</span>
                                                    </a>
                                        <a href="{{ route('admin.users.force_delete', $user->id) }}" class="btn btn-danger" onclick="return confirm('Are you sure want to delete this record permanently?')">
                                                        <i class="align-middle" data-feather="x"></i>
                                                        <span class="align-middle">force delete</span>
                                                    </a> @else
                                        <a href="{{ route('admin.users.edit', $user)}}" class="btn btn-warning">
                                                        <i class="align-middle" data-feather="edit"></i> 
                                                        <span class="align-middle">edit</span>
                                                    </a>

                                        <form method="post" action="{{ route('admin.users.destroy', $user) }}">
                                            @method('DELETE') @csrf
                                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure want to delete?')">
                                                <i class="align-middle" data-feather="delete"></i> 
                                                <span class="align-middle">delete</span>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            <td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center"> No Data Found</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="mt-2">
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection