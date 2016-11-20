@extends('layouts.main')

@section('content')

    <div class="page-header">
        <h1>Test Thing</h1>
    </div>

    <!-- Nav tabs -->
    <div class="row">
        <div class="col-md-12">
            <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" data-toggle="tab" href="#profile" role="tab">Profile</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#org" role="tab">Organization</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#fleet" role="tab">Fleet</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#squad" role="tab">Squadron</a>
                </li>
            </ul>
        </div>
    </div>

    <!-- Tab panes -->
    <div class="row">
        <div class="tab-content col-md-12">
            <div class="tab-pane active" id="profile" role="tabpanel">
                profile
            </div>
            <div class="tab-pane" id="org" role="tabpanel">
                org
            </div>
            <div class="tab-pane" id="fleet" role="tabpanel">
                fleet
            </div>
            <div class="tab-pane" id="squad" role="tabpanel">
                squad
            </div>
        </div>
    </div>


    <script>
        /*
         $.getJSON("/api/v4/users", function (users) {
         $.each(users, function (index, user) {
         setTimeout(function() {
         $.getJSON("/api/v4/users/" + user.id, function (data) {
         $('#name').text("Name: " + data.name);
         if (data.organization_id === null) {
         $('#org').text("Organization: NAN");
         } else {
         $('#org').text("Organization: " + data.organization.name);
         }
         if (data.fleet_id === null) {
         $('#fleet').text("Fleet: NAN");
         } else {
         $('#fleet').text("Fleet: " + data.fleet.name);
         }
         if (data.squad_id === null) {
         $('#squad').text("Squad: NAN");
         } else {
         $('#squad').text("Squad: " + data.squad.name);
         }
         $('#ships').text("Ships: " + (data.ships).length);
         console.log("Accessed element " + index + " out of " + users.length);
         });
         },(index * 1000));
         });
         });
         */
    </script>

@endsection