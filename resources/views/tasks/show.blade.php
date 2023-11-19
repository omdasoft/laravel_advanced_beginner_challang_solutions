@extends('layouts.dashboard') 
@section('content')
<div class="row">
    <div class="accordion" id="accordionPanelsStayOpenExample">
        <div class="accordion-item">
            <h2 class="accordion-header" id="panelsStayOpen-headingOne">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="true"
                    aria-controls="panelsStayOpen-collapseOne">
                      Task Information
                    </button>
            </h2>
            <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse show" aria-labelledby="panelsStayOpen-headingOne">
                <div class="accordion-body">
                    <h3>{{ $task->title }}</h3>
                    <p class="lead">{{ $task->description }}</p>
                    <div class="d-flex">
                        <div class="me-5">
                            <span>Status</span>
                            <span class="badge {{ getStatusColorClass($task->status) }}">{{ $task->status }}</span>
                        </div>
                        <div class="me-5">
                            <span>Dateline</span>
                            <span class="badge bg-black">{{ $task->dateline}}</span>
                        </div>
                        <div>
                            <span>Created Date</span>
                            <span class="badge bg-black">{{ $task->created_at->format('Y-m-d')}}</span>
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
                            <td>{{ $task->user->full_name }}</td>
                        </tr>
                        <tr>
                            <td><b>Email: </b></td>
                            <td>{{ $task->user->email }}</td>
                        </tr>
                        <tr>
                            <td><b>Phone: </b></td>
                            <td>{{ $task->user->phone_number }}</td>
                        </tr>
                        <tr>
                            <td><b>Address: </b></td>
                            <td>{{ $task->user->address }}</td>
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
                            <td>{{ $task->client->contact_name }}</td>
                        </tr>
                        <tr>
                            <td><b>Email: </b></td>
                            <td>{{ $task->client->contact_email }}</td>
                        </tr>
                        <tr>
                            <td><b>Phone: </b></td>
                            <td>{{ $task->client->contact_phone_number }}</td>
                        </tr>
                        <tr>
                            <td><b>Company: </b></td>
                            <td>{{ $task->client->company_name }}</td>
                        </tr>
                        <tr>
                            <td><b>Address: </b></td>
                            <td>{{ $task->client->company_address }}</td>
                        </tr>
                        <tr>
                            <td><b>City: </b></td>
                            <td>{{ $task->client->company_city }}</td>
                        </tr>

                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection