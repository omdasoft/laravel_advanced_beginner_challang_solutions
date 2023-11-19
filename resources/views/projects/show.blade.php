@extends('layouts.dashboard') 
@section('content')
<div class="row">
    <div class="accordion" id="accordionPanelsStayOpenExample">
        <div class="accordion-item">
            <h2 class="accordion-header" id="panelsStayOpen-headingOne">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="true"
                    aria-controls="panelsStayOpen-collapseOne">
                      Project Information
                    </button>
            </h2>
            <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse show" aria-labelledby="panelsStayOpen-headingOne">
                <div class="accordion-body">
                    <h3>{{ $project->title }}</h3>
                    <p class="lead">{{ $project->description }}</p>
                    <div class="d-flex">
                        <div class="me-5">
                            <span>Status</span> 
                            <span class="badge {{ getStatusColorClass($project->status) }}">{{ $project->status }}</span>
                        </div>
                        <div class="me-5">
                            <span>Dateline</span>
                            <span class="badge bg-black">{{ $project->dateline}}</span>
                        </div>
                        <div>
                            <span>Created Date</span>
                            <span class="badge bg-black">{{ $project->created_at->format('Y-m-d')}}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="accordion-item">
            <h2 class="accordion-header" id="panelsStayOpen-headingTwo">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseTwo"
                    aria-expanded="false" aria-controls="panelsStayOpen-collapseTwo">
                      Assigned User
                    </button>
            </h2>
            <div id="panelsStayOpen-collapseTwo" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingTwo">
                <div class="accordion-body">
                    <table>
                        <tr>
                            <td><b>User Name: </b></td>
                            <td>{{ $project->user->full_name }}</td>
                        </tr>
                        <tr>
                            <td><b>Email: </b></td>
                            <td>{{ $project->user->email }}</td>
                        </tr>
                        <tr>
                            <td><b>Phone: </b></td>
                            <td>{{ $project->user->phone_number }}</td>
                        </tr>
                        <tr>
                            <td><b>Address: </b></td>
                            <td>{{ $project->user->address }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <div class="accordion-item">
            <h2 class="accordion-header" id="panelsStayOpen-headingThree">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseThree"
                    aria-expanded="false" aria-controls="panelsStayOpen-collapseThree">
                      Client Details
                    </button>
            </h2>
            <div id="panelsStayOpen-collapseThree" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingThree">
                <div class="accordion-body">
                    <table>
                        <tr>
                            <td><b>Name: </b></td>
                            <td>{{ $project->client->contact_name }}</td>
                        </tr>
                        <tr>
                            <td><b>Email: </b></td>
                            <td>{{ $project->client->contact_email }}</td>
                        </tr>
                        <tr>
                            <td><b>Phone: </b></td>
                            <td>{{ $project->client->contact_phone_number }}</td>
                        </tr>
                        <tr>
                            <td><b>Company: </b></td>
                            <td>{{ $project->client->company_name }}</td>
                        </tr>
                        <tr>
                            <td><b>Address: </b></td>
                            <td>{{ $project->client->company_address }}</td>
                        </tr>
                        <tr>
                            <td><b>City: </b></td>
                            <td>{{ $project->client->company_city }}</td>
                        </tr>

                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection