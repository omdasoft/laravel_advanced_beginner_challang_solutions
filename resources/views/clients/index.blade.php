@extends('layouts.dashboard') 
@section('content')
<div class="row">
    <div class="col-md-12 d-flex">
        <div class="card flex-fill">
            <div class="card-header d-flex justify-content-between">
                <h5 class="card-title mb-0 mr-2">Clients</h5>
                <a href="{{ route('admin.clients.create')}}" class="btn btn-default">
                    <i class="align-middle me-2" data-feather="plus-square"></i> 
                    <span class="align-middle">Add</span>
                </a>
            </div>
            <div class="card-body">
                @if(request()->has('view_deleted'))
                <a href="{{ route('admin.clients.index') }}" class="btn btn-info">View All Clients</a>
                <a href="{{ route('admin.clients.restore.all') }}" class="btn btn-success">
                        <i class="align-middle" data-feather="rotate-ccw"></i>
                        <span class="align-middle">Restore All</span>
                    </a>
                <a href="{{ route('admin.clients.force_delete.all') }}" class="btn btn-danger" onclick="return confirm('Are you sure want to delete all the trashed records permanently?')">
                        <i class="align-middle" data-feather="x"></i>
                        <span class="align-middle">Force Delete All</span>
                    </a> @else @if(deleted_records_count('clients'))
                <a href="{{ route('admin.clients.index', ['view_deleted' => 'DeletedRecords']) }}" class="btn btn-primary">View Delete Records ({{ deleted_records_count('clients') }})</a>                @endif @endif
                <table class="table table-hover my-0">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Comp Name</th>
                            <th>City</th>
                            <th>Vat</th>
                            <th>ZIP</th>
                            <th>#</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($clients as $client)
                        <tr>
                            <td>{{ $client->contact_name }}</td>
                            <td>{{ $client->contact_email }}</td>
                            <td>{{ $client->contact_phone_number }}</td>
                            <td>{{ $client->company_name }}</td>
                            <td>{{ $client->company_city }}</td>
                            <td>{{ $client->company_vat }}</td>
                            <td>{{ $client->contact_zip }}</td>
                            <td>
                                <div class="d-flex justify-content-between buttons-groups">
                                    @if(request()->has('view_deleted'))
                                        <a href="{{ route('admin.clients.restore', $client->id) }}" class="btn btn-success">
                                                                <i class="align-middle" data-feather="rotate-ccw"></i>
                                                                <span class="align-middle">restore</span>
                                                        </a>
                                        <a href="{{ route('admin.clients.force_delete', $client->id) }}" class="btn btn-danger" onclick="return confirm('Are you sure want to delete this record permanently?')">
                                                            <i class="align-middle" data-feather="x"></i>
                                                            <span class="align-middle">force delete</span>
                                                        </a> 
                                    @else
                                        <a href="{{ route('admin.clients.edit', $client)}}" class="btn btn-warning">
                                            <i class="align-middle" data-feather="edit"></i> 
                                            <span class="align-middle">edit</span>
                                        </a>

                                        <form method="post" action="{{ route('admin.clients.destroy', $client) }}">
                                            @method('DELETE') @csrf
                                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure want to delete?')">
                                                <i class="align-middle" data-feather="delete"></i> 
                                                <span class="align-middle">delete</span>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="text-center"> No Data Found</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="mt-2">
                    {{ $clients->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection