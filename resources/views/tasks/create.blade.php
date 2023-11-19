@extends('layouts.dashboard') 
@section('content')
<div class="row">
    <div class="col-md-12 d-flex">
        <div class="card flex-fill">
            <div class="card-header">
                <h5 class="card-title mb-0 mr-2">Create New</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.tasks.store') }}" method="post">
                    @csrf
                    <div class="row mb-2">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="title">Title</label>
                                <input type="text" name="title" value="{{ old('title') }}" id="title" class="form-control @error('title') is-invalid @enderror"
                                /> @error('title')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span> @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea name="description" rows="10" class="form-control @error('description') is-invalid @enderror">{{ old('description') }}</textarea>
                                @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span> 
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="dateline">Dateline</label>
                                <input type="date" name="dateline" value="{{ old('dateline') }}" id="dateline" class="form-control @error('dateline') is-invalid @enderror"
                                /> @error('dateline')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span> @enderror
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="contact_zip">Status</label>
                                <select name="status" value=" {{ old('status') }}"class="form-control @error('status') is-invalid @enderror">
                                    <option value="" selected disabled>-- Select Status -- </option>
                                    @foreach(\App\Enums\StatusEnum::values() as $key => $value)
                                        <option value="{{ $key }}" {{ old('status') == $key ? 'selected':'' }}>{{ $value }}</option>
                                    @endforeach
                                </select>
                                @error('status')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span> 
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-4">
                            <div class="form-group">
                                <label for="user_id">User</label>
                                <select name="user_id" value=" {{ old('user_id') }}"class="form-control @error('user_id') is-invalid @enderror">
                                    <option value="" selected disabled>-- Select User -- </option>
                                    @forelse($users as $user)
                                        <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected':'' }}>{{ $user->first_name }}</option>
                                    @empty
                                        <option value="">No Users</option>
                                    @endforelse
                                </select>
                                @error('user_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span> 
                                @enderror
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                    <label for="client_id">Client</label>
                                    <select name="client_id" value=" {{ old('client_id') }}"class="form-control @error('client_id') is-invalid @enderror">
                                        <option value="" selected disabled>-- Select Client -- </option>
                                        @forelse($clients as $client)
                                            <option value="{{ $client->id }}" {{ old('client_id') == $client->id ? 'selected':'' }}>{{ $client->contact_name }}</option>
                                        @empty
                                            <option value="">No Clients</option>
                                        @endforelse
                                    </select>
                                    @error('client_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span> 
                                    @enderror
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                    <label for="project_id">Project</label>
                                    <select name="project_id" value=" {{ old('project_id') }}"class="form-control @error('project_id') is-invalid @enderror">
                                        <option value="" selected disabled>-- Select Project -- </option>
                                        @forelse($projects as $project)
                                            <option value="{{ $project->id }}" {{ old('project_id') == $project->id ? 'selected':'' }}>{{ $project->title }}</option>
                                        @empty
                                            <option value="">No Tasks</option>
                                        @endforelse
                                    </select>
                                    @error('project_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span> 
                                    @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <input type="submit" name="submit" value="Create" class="btn btn-success">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection