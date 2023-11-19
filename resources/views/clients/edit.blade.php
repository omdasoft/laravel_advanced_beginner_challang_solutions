@extends('layouts.dashboard') 
@section('content')
<div class="row">
    <div class="col-md-12 d-flex">
        <div class="card flex-fill">
            <div class="card-header">
                <h5 class="card-title mb-0 mr-2">Edit Client</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.clients.update', $client)}}" method="post">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="id" value="{{ $client->id }}">
                    <div class="row mb-2">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="contact_name">Contact Name</label>
                                <input type="text" name="contact_name" value="{{ $client->contact_name }}" id="contact_name" class="form-control @error('contact_name') is-invalid @enderror"
                                /> @error('contact_name')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span> @enderror
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="contact_email">Contact Email</label>
                                <input type="text" name="contact_email" value="{{ $client->contact_email }}" id="contact_email" class="form-control @error('contact_email') is-invalid @enderror"
                                /> @error('contact_email')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span> @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="contact_phone_number">Contact Phone Number</label>
                                <input type="text" name="contact_phone_number" value="{{ $client->contact_phone_number }}" id="contact_phone_number" class="form-control @error('contact_phone_number') is-invalid @enderror"
                                /> @error('contact_phone_number')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span> @enderror
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="contact_zip">Contact ZIP</label>
                                <input type="text" name="contact_zip" id="contact_zip" value="{{ $client->contact_zip }}" class="form-control @error('contact_zip') is-invalid @enderror"
                                /> @error('contact_zip')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span> @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="company_name">Company Name</label>
                                <input type="text" name="company_name" value="{{ $client->company_name }}" id="company_name" class="form-control @error('company_name') is-invalid @enderror"
                                /> @error('company_name')
                                <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span> @enderror
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="company_address">Company Address</label>
                                <input type="text" name="company_address" value="{{ $client->company_address }}" id="company_address" class="form-control @error('company_address') is-invalid @enderror"
                                /> @error('company_address')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span> @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="company_city">Company City</label>
                                <input type="text" name="company_city" value="{{ $client->company_city }}" id="company_city" class="form-control @error('company_city') is-invalid @enderror"
                                /> @error('company_city')
                                <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span> @enderror
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="company_vat">Company VAT</label>
                                <input type="text" name="company_vat" id="company_vat" value="{{ $client->company_vat }}" class="form-control @error('company_vat') is-invalid @enderror"
                                /> @error('company_vat')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span> @enderror
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