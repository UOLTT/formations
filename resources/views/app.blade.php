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

        <!-- Begin Administration -->
        <div class="panel-group HideWhenLoading" style="display: none">
            <div class="panel panel-default">

                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" href="#administration">Administration</a>
                    </h4>
                </div>

                <div id="administration" class="panel-collapse collapse">

                    <div class="panel-body">

                        <!-- Begin Admin Panels -->
                        <div class="row">

                            <!-- Begin Org -->
                            <div class="col-md-4" id="orgPanel">
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
                            <div class="col-md-4" id="fleetPanel">
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
                            <div class="col-md-4" id="squadPanel">
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
                        <!-- /Admin Panels -->

                    </div>

                </div>

            </div>
        </div>
        <!-- /Administration -->

        <!-- Begin Ship Setup -->
        <div class="panel-group HideWhenLoading" style="display: none">
            <div class="panel panel-default">

                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" href="#shipSetup">Ship Setup</a>
                    </h4>
                </div>

                <div id="shipSetup" class="panel-collapse collapse">
                    <div class="panel-body">

                        <!-- Begin Ship Panel -->
                        <div class="row" id="shipsPanel">
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

                        <br>

                        <!-- Begin Station Panel -->
                        <div class="row" id="stationsPanel">
                            <div class="col-md-12">
                                <div class="panel panel-primary">
                                    <div class="panel-heading">
                                        <h3 class="panel-title">I am am stationed as:</h3>
                                    </div>
                                    <div class="panel-body">
                                        <div class="list-group" id="stationsList">
                                            <a href="#" class="list-group-item">
                                                <h4 class="list-group-item-heading">Loading...</h4>
                                                <p class="list-group-item-text">...</p>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /Station Panel -->

                    </div>
                </div>

            </div>
        </div>
        <!-- /Ship Setup -->

        <!-- Begin Formation Panel -->
        <div class="panel-group HideWhenLoading" style="display: none">
            <div class="panel panel-default">

                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" href="#collapse1">Squad Formation</a>
                    </h4>
                </div>

                <div id="collapse1" class="panel-collapse collapse">
                    <div class="panel-body">
                        // TODO Formation stuff
                    </div>
                </div>

            </div>
        </div>
        <!-- /Formation Panel -->

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

                        if (UserData.active_ship.user_id == UserID) { // if user is running their own ship
                            myShipChecked(true);
                        }else { // if user is running someone elses ship
                            myShipChecked(false);
                            $('#whoseShip').show();
                            updateWhoseShipList(UserData.active_ship.user_id,UserData.active_ship.ship_id);
                        }

                        // Function to toggle between checked and unchecked for the myShip class radio thing
                        function myShipChecked(checked) {
                            $('.myShip').each(function(index) {
                                if ($(this).value == 0) {
                                    $(this).prop('checked',checked);
                                }else {
                                    $(this).prop('checked',!checked);
                                }
                            });
                        }

                        // Update the stations available for that ship
                        updateStationsList(UserData.active_ship.ship_id,UserData.station_id);

                        // delay hiding the loading panel so everything has time to render
                        setTimeout(function() {
                            // Hide loading panel and show everything else
                            $('#loadingPanel').hide();
                            $('.HideWhenLoading').show();
                        }, 1000);
                    });

            // When user changes if they are using their or a squadmates ship
            $('.myShip').on('change',function() {
                if (this.value != 0) { // if using squad mates ship
                    // show the select box
                    $('#whoseShip').show();
                    updateWhoseShipList();
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

            function changeActiveShip(ShipID) {
                updateActiveShip(ShipID);
                updateStationsList(ShipID);
                var activeUserID;
                if ($('input[name=myShip]:checked').val() == 0) {
                    activeUserID = UserID;
                }else {
                    activeUserID = $('#whoseShip').val();
                }
                $.post("/api/v4/users/" + UserID, {
                    token: Token,
                    _method: "patch",
                    active_ship: {
                        user_id: activeUserID,
                        ship_id: ShipID
                    }
                });
            }

            function updateActiveShip(ShipID) {
                // for each shipListItem...
                $('.shipListItems').each(function(index) {
                    if ($(this).hasClass("active") && $(this).attr('id') != "Ship" + ShipID) { // if item is active and not desired ship
                        $(this).removeClass("active"); // un-activate that element
                    }else if ($(this).attr('id') == "Ship" + ShipID) { // if item is desired ship
                        $(this).addClass("active"); // activate item
                    }
                });
            }

            function updateShipList(PlayerID,ActiveShip) {
                if (PlayerID == UserID) { // already have data, no need for ajax
                    update(UserData.ships);
                }else { // we need to get that users ships
                    // Loading FTW
                    $('#shipList').html('<a class="list-group-item">Loading...</a>');
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
                        shipListHtml = shipListHtml +
                                '<a id="Ship' + ShipData.id + '" class="list-group-item shipListItems" onclick="changeActiveShip(' + ShipData.id + ')">' +
                                ShipData.shipname +
                                '</a>';
                    });
                    // Inject HTML
                    $('#shipList').html(shipListHtml);
                    if (ActiveShip) {
                        // Add active class to proper element
                        updateActiveShip(ActiveShip);
                    }
                }
            }

            function updateStationsList(ShipID,SelectedStationID) {
                var ShipData;
                var StationsListHTML = "";
                $('#stationsList').html(
                    '<a class="list-group-item">' +
                        '<h4 class="list-group-item-heading">Loading...</h4>' +
                        '<p class="list-group-item-text">...</p>' +
                    '</a>'
                );
                $.getJSON("/api/v4/ships/" + ShipID,function(response) {
                    ShipData = response;
                })
                        .done(function() {
                            $.each(ShipData.stations,function(index,Station) {
                                var Active = "";
                                if (SelectedStationID == Station.id) {
                                    Active = " active";
                                }
                                StationsListHTML = StationsListHTML +
                                        '<a class="list-group-item' + Active + '">' +
                                            '<h4 class="list-group-item-heading">' + Station.name + '</h4>' +
                                            '<p class="list-group-item-text">' + Station.description + '</p>' +
                                        '</a>';
                            });
                            $('#stationsList').html(StationsListHTML);
                        });
            }

            function updateWhoseShipList(SelectedUserID,ActiveShip) {
                var squadOptions = ""; // HTML for squad options
                var firstUserID; // ID of first user

                // get the users that belong to that squad
                $.getJSON("/api/v4/squads/" + UserData.squad_id, function(SquadData) {
                    $.each(SquadData.users, function(index, User) {
                        var Selected = "";
                        // if selected user not provided, get first users ID and load their ships
                        if (!firstUserID && !SelectedUserID) {
                            firstUserID = User.id;
                        }else if (SelectedUserID == User.id) {
                            Selected = "selected"
                        }
                        // Add option to html variable
                        squadOptions = squadOptions + "<option " + Selected + " value='" + User.id + "'>" + User.name + "</option>";
                    });
                })
                        .done(function() {
                            if (!SelectedUserID) {
                                // update ship list with first users ships
                                updateShipList(firstUserID,ActiveShip);
                            }else {
                                // update ship list with selected users ships
                                updateShipList(SelectedUserID,ActiveShip);
                            }
                            // update the select box with the new options
                            $('#whoseShip').html(squadOptions);
                        });
            }
        </script>

    @endif

@endsection