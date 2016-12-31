@extends('layouts.main')

@section('content')

    <div class="page-header">
        <h1>Web Application</h1>
    </div>

    @if(is_null(\Auth::user()->squad_id))

        <div class="row">
            <div class="col-md-12">
                <p>You must complete your profile before using this application</p>
            </div>
        </div>

    @else

        <!-- Begin Overview -->
        <div class="row">

            <!-- Begin Loading -->
            <div class="col-md-12" id="loadingPanel">
                <div class="progress">
                    <div class="progress-bar progress-bar-striped active" role="progressbar"
                         aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width:100%">
                        Loading...
                    </div>
                </div>
            </div>
            <!-- /Loading -->

            <!-- Begin Org -->
            <div class="col-md-4 HideWhenLoading" id="orgPanel" style="display: none">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title">ORG NAME</h3>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-6">
                                <b>Organization Status:</b>
                            </div>
                            <div class="col-md-6">
                                <select id="orgStatus" class="form-control">
                                    @foreach(\App\Status::where('type','Organization')->get(['name','id']) as $Status)
                                        <option value="{{ $Status->id }}">{{ $Status->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Org -->

            <!-- Begin Fleet -->
            <div class="col-md-4 HideWhenLoading" id="fleetPanel" style="display: none">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title">FLEET NAME</h3>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-6">
                                <b>Fleet Status:</b>
                            </div>
                            <div class="col-md-6">
                                <select id="fleetStatus" class="form-control">
                                    @foreach(\App\Status::where('type','Fleet')->get(['name','id']) as $Status)
                                        <option value="{{ $Status->id }}">{{ $Status->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Fleet -->

            <!-- Begin Squad -->
            <div class="col-md-4 HideWhenLoading" id="squadPanel" style="display: none">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title">SQUAD NAME</h3>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-6">
                                <b>Squadron Status:</b>
                            </div>
                            <div class="col-md-6">
                                <select id="squadStatus" class="form-control">
                                    @foreach(\App\Status::where('type','Squadron')->get(['name','id']) as $Status)
                                        <option value="{{ $Status->id }}">{{ $Status->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Squad -->

        </div>
        <!-- /Overview -->

        <!-- Begin Ship Panel -->
        <div class="row HideWhenLoading" id="shipsPanel" style="display: none">
            <div class="col-md-12">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title">I am flying...</h3>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-4">
                                <p>
                                    <input type="radio" name="myShip" class="myShip" value="0" checked> My Ship<br>
                                    <input type="radio" name="myShip" class="myShip" value="1"> Squadmates Ship
                                </p>
                                <p>
                                    <select class="form-control" id="whoseShip" style="display: none">
                                        <option>Loading...</option>
                                    </select>
                                </p>
                            </div>
                            <div class="col-md-8">
                                <div class="list-group" id="shipList">
                                    <!-- this gets filled with ship data -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Ship Panel -->

        <!-- Begin Station Panel -->
        <div class="row HideWhenLoading" id="stationsPanel" style="display: none">
            <div class="col-md-12">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title">I am am stationed as:</h3>
                    </div>
                    <div class="panel-body">
                        <div class="list-group">
                            <a href="#" class="list-group-item">
                                <h4 class="list-group-item-heading">List group item heading</h4>
                                <p class="list-group-item-text">Donec id elit non mi porta gravida at eget metus. Maecenas sed diam eget risus varius blandit.</p>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Station Panel -->

        <script>
            var Token = "{{ $token }}"; // Users application token
            var UserID = "{{ \Auth::user()->id }}"; // Users ID
            var UserData; // User Data

            // async load the users data
            // TODO convert to function and run periodically ?
            $.getJSON("/api/v4/users/" + UserID, function (response) {
                UserData = response;
                console.log(UserData);
            })
                    .done(function() {
                        // Check if Org admin
                        if (UserData.id != UserData.organization.admin_user_id) {
                            $('#orgStatus').prop('disabled',true);
                        }
                        // Check if Fleet admiral
                        if (UserData.id != UserData.fleet.admiral_id) {
                            $('#fleetStatus').prop('disabled',true);
                        }
                        // Check if Squad leader
                        if (UserData.id != UserData.squad.squad_leader_id) {
                            $('#squadStatus').prop('disabled',true);
                        }

                        // Make sure ship list is populated
                        updateShipList(UserID);

                        // Hide loading panel and show everything else
                        $('#loadingPanel').hide();
                        $('.HideWhenLoading').show();
                    });

            // When user changes if they are using their or a squadmates ship
            $('.myShip').on('change',function() {
                if (this.value != 0) { // if using squad mates ship
                    // show the select box
                    $('#whoseShip').show();


                    var squadOptions = ""; // HTML for squad options
                    var firstUserID; // ID of first user

                    // get the users that belong to that squad
                    $.getJSON("/api/v4/squads/" + UserData.squad_id, function(SquadData) {
                        $.each(SquadData.users, function(index, User) {
                            // get first users ID and load their ships
                            if (!firstUserID) {
                                firstUserID = User.id;
                            }
                            // Add option to html variable
                            squadOptions = squadOptions + "<option value='" + User.id + "'>" + User.name + "</option>";
                        });
                    })
                            .done(function() {
                                // update ship list with first users ships
                                updateShipList(firstUserID);
                                // update the select box with the new options
                                $('#whoseShip').html(squadOptions);
                            });
                }else { // if using own ships
                    // reset users list drop-down to default value
                    $('#whoseShip').html("<option>Loading...</option>");
                    // update ship list to correct users ships
                    updateShipList(UserID);
                    // hide the squad mates select box
                    $('#whoseShip').hide();
                }
            });

            // When user changes the org status, send AJAX to update the org
            $('#orgStatus').on('change', function () {
                console.log({
                    token: Token,
                    _method: "patch",
                    status_id: Number(this.value)
                });
                $.post("/api/v4/organizations/{{ \Auth::user()->organization_id }}", {
                    token: Token,
                    _method: "patch",
                    status_id: Number(this.value)
                });
            });
            // When user changes the fleet status, send AJAX to update the fleet
            $('#fleetStatus').on('change', function () {
                console.log({
                    token: Token,
                    _method: "patch",
                    status_id: Number(this.value)
                });
                $.post("/api/v4/fleets/{{ \Auth::user()->fleet_id }}", {
                    token: Token,
                    _method: "patch",
                    status_id: Number(this.value)
                });
            })
            // TODO implement above for squad status

            // When user changes whose ship they are flying in, update ship list with that users ships
            $('#whoseShip').on('change', function() {
                updateShipList(this.value);
            });

            function updateShipList(PlayerID) {
                if (PlayerID == UserID) { // already have data, no need for ajax
                    update(UserData.ships);
                }else { // we need to get that users ships
                    // Loading FTW
                    $('#shipList').html('<a href="#" class="list-group-item">Loading...</a>');
                    // get that users ships
                    $.getJSON("/api/v4/users/" + PlayerID, function(User) {
                        update(User.ships);
                    });
                }

                // private function to update the ships list, provided an array of ship objects
                function update(shipsArray) {
                    var shipListHtml = ""; // HTML to insert into the ships list
                    // For each ship object, append that HTML to shipListHtml
                    $.each(shipsArray, function(index, ShipData) {
                        shipListHtml = shipListHtml + '<a href="#" class="list-group-item">' + ShipData.shipname + '</a>';
                    });
                    // Inject HTML
                    $('#shipList').html(shipListHtml);
                }

            }
        </script>

    @endif

@endsection