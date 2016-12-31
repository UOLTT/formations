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

        <div class="row">
            <div class="col-md-12" id="loadingPanel">
                <div class="progress">
                    <div class="progress-bar progress-bar-striped active" role="progressbar"
                         aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width:100%">
                        Loading...
                    </div>
                </div>
            </div>


            <div class="col-md-4" id="orgPanel" style="display: none">
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


            <div class="col-md-4" id="fleetPanel" style="display: none">
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


            <div class="col-md-4" id="squadPanel" style="display: none">
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
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-primary" id="shipsPanel" style="display: none">
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

        <script>
            var Token = "{{ $token }}";
            var UserID = "{{ \Auth::user()->id }}";
            var UserData;

            $.getJSON("/api/v4/users/" + UserID, function (response) {
                UserData = response;
                console.log(UserData);
            })
                    .done(function() {
                        if (UserData.id != UserData.organization.admin_user_id) {
                            $('#orgStatus').prop('disabled',true);
                        }
                        if (UserData.id != UserData.fleet.admiral_id) {
                            $('#fleetStatus').prop('disabled',true);
                        }
                        if (UserData.id != UserData.squad.squad_leader_id) {
                            $('#squadStatus').prop('disabled',true);
                        }

                        updateShipList(UserID);

                        $('#loadingPanel').hide();
                        $('#orgPanel').show();
                        $('#fleetPanel').show();
                        $('#squadPanel').show();
                        $('#shipsPanel').show();
                    });

            $('.myShip').on('change',function() {
                // if using squad mates ship
                if (this.value != 0) {
                    // show the select box
                    $('#whoseShip').show();
                    var squadOptions = "";
                    var firstUserID;
                    // get the users that belong to that squad
                    $.getJSON("/api/v4/squads/" + UserData.squad_id, function(SquadData) {
                        $.each(SquadData.users, function(index, User) {
                            // get first users ID and load their ships
                            if (!firstUserID) {
                                firstUserID = User.id;
                            }
                            squadOptions = squadOptions + "<option value='" + User.id + "'>" + User.name + "</option>";
                        });
                    })
                            .done(function() { // update the select box with the new options
                                updateShipList(firstUserID);
                                $('#whoseShip').html(squadOptions);
                            });
                }else {
                    $('#whoseShip').html("<option>Loading...</option>");
                    updateShipList(UserID);
                    $('#whoseShip').hide();
                }
            });

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

            $('#whoseShip').on('change', function() {
                updateShipList(this.value);
            });

            function updateShipList(PlayerID) {

                var PlayerShips;
                // already have data, no need for ajax
                if (PlayerID == UserID) {
                    update(UserData.ships);
                }else {
                    $('#shipList').html('<a href="#" class="list-group-item">Loading...</a>');
                    $.getJSON("/api/v4/users/" + PlayerID, function(User) {
                        update(User.ships);
                    });
                }

                function update(shipsArray) {
                    var shipListHtml = "";
                    $.each(shipsArray, function(index, ShipData) {
                        shipListHtml = shipListHtml + '<a href="#" class="list-group-item">' + ShipData.shipname + '</a>';
                    });
                    $('#shipList').html(shipListHtml);
                }

            }
        </script>

    @endif

@endsection