@extends('layouts.dashboard') 
@section('content')
<div class="row">
    <div class="col-md-12 d-flex">
        <div class="card flex-fill">
            <div class="card-header">
                <h5 class="card-title mb-0 mr-2">Update User</h5>
            </div>
            <div class="card-body">
                <form method="post" action="{{ route('admin.users.update', $user->id) }}">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="id" value="{{ $user->id }}">
                    <div class="row mb-2">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="first_name">First Name</label>
                                <input type="text" name="first_name" value="{{ $user->first_name }}" id="first_name" class="form-control @error('first_name') is-invalid @enderror" />
                                @error('first_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="last_name">Last Name</label>
                                <input type="text" name="last_name" value="{{ $user->last_name }}" id="last_name" class="form-control @error('last_name') is-invalid @enderror" />
                                @error('last_name')
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
                                <label for="email">Email</label>
                                <input type="text" name="email" value="{{ $user->email }}" id="email" class="form-control @error('last_name') is-invalid @enderror" />
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="address">Address</label>
                                <input type="text" name="address" value="{{ $user->address }}" id="address" class="form-control @error('address') is-invalid @enderror" />
                                @error('address')
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
                                <label for="phone_number">Phone</label>
                                <input type="text" name="phone_number" value="{{ $user->phone_number }}" id="phone_number" class="form-control @error('phone_number') is-invalid @enderror" />
                                @error('phone_number')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="role">Role</label>
                                <select class="form-control @error('role') is-invalid @enderror" name="role" id="role">
                                    <option value="" selected disabled>- select option -</option>
                                    @foreach($roles as $role) 
                                        <option value="{{ $role->id }}" {{ $user->roles->pluck('id')[0] == $role->id ? 'selected' : '' }}>
                                            {{ $role->name}}
                                        </option>
                                    @endforeach
                                </select>
                                @error('role')
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
                                <label for="password">Password</label>
                                <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" />
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                 @enderror
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="password_confirm">Password Confirm</label>
                                <input type="password" name="password_confirmation" id="password_confirm" class="form-control" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <input type="submit" name="submit" value="Update" class="btn btn-success">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection