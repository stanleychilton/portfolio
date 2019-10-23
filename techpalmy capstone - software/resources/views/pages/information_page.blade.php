@extends('layouts.app')

@section('content')
    <!--Section heading-->
    <br>
    <h2 class="section-header h2 text-center">Information Page</h2>

    <!--Section description-->
    <div class="row">
        <div class="col-6">
            <div class="card bg-faded" id="infoPageCard">
                <div class="card-header">
                    Create Companies
                </div>
                <div class="card-body">
                    <p class="card-text">
                        Create a company. Each user can list one company. This company will be bound to you;
                        you will have admin privilages. 
                    </p>
                    <br>
                    <a href='/companies/create' class = 'btn btn-primary'>Create Company</a>
                </div>
            </div>
        </div>
        <div class="col-6">
            <div class="card bg-faded" id="infoPageCard">
                <div class="card-header">
                    Create Tech Group
                </div>
                <div class="card-body">
                    <p class="card-text">
                        Create a tech group. Each user can list multiple tech groups. This tech group will be bound to you;
                        you will have admin privilages. 
                    </p>
                    <br>
                    <a href='/techgroups/create' class = 'btn btn-primary'>Create Tech Group</a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-6">
            <div class="card bg-faded" id="infoPageCard">
                <div class="card-header">
                    Create Consultancy
                </div>
                <div class="card-body">
                    <p class="card-text">
                        Create a consultant. Each user can list one consultant. This consultant will be bound to you;
                        you will have admin privilages. 
                    </p>
                    <br>
                    <a href='/consultants/create' class = 'btn btn-primary'>Create Consultant</a>
                </div>
            </div>
        </div>    
        <div class="col-6">
            <div class="card bg-faded" id="infoPageCard">
                <div class="card-header">
                    Create Job
                </div>
                <div class="card-body">
                <p class="card-text">
                    Create a job. Each user can list many jobs. This job will be bound to you;
                    you will have admin privilages. You must be an admin of an approved company in order to create a job.
                </p>
                <a href='/jobs/create' class = 'btn btn-primary'>Create Job</a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-6">
            <div class="card bg-faded" id="infoPageCard">
                <div class="card-header">
                    Create Event
                </div>
                <div class="card-body">
                    <p class="card-text">
                        Create an event. Each user can list five events. This event will be bound to you;
                        you will have admin privilages. 
                    </p>
                    <br>
                    <a href='/events/create' class = 'btn btn-primary'>Create Event</a>
                </div>
            </div>
        </div>    
        <div class="col-6">
            <button type="button" class="btn btn-primary btn-block" data-toggle="modal" data-target="#TermsAndConditionsModal" id="infoPageCard">
                Tech Palmy Terms and Conditions
            </button>
        </div>
    </div>

    @include('inc.terms_and_conditions')

@endsection