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
                @if(!is_null(\Auth::user()->organization_id))
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#fleet" role="tab">Fleet</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#squad" role="tab">Squadron</a>
                    </li>
                @endif
            </ul>
        </div>
    </div>

    <!-- Tab panes -->
    <div class="row">
        <div class="tab-content col-md-12">

            <!-- profile -->
            <div class="tab-pane active" id="profile" role="tabpanel">
                <table class="table table-condensed">
                    <tbody>
                    <tr>
                        <td width="40%">
                            Name
                        </td>
                        <td width="60%">
                            <input type="text" name="name" id="username" class="form-control"
                                   value="{{ \Auth::user()->name }}">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Ships
                        </td>
                        <td>
                            <select class="form-control" multiple="multiple" size="15" name="ships" id="userships">
                                @foreach (\App\Ship::with(['users'=>function($query) {$query->where('users.id',\Auth::user()->id);}])->orderBy('shipname')->get(['id','shipname']) as $Ship)
                                    <option value="{{ $Ship->id }}" {{ (count($Ship->users) ? "selected" : "") }}>{{ $Ship->shipname }}</option>
                                @endforeach
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Devices<br>
                            <small>(Athentication codes used for external apps)</small>
                        </td>
                        <td>
                            <ul class="list-group">
                                @foreach(\Auth::user()->devices as $Device)
                                    <li class="list-group-item">
                                        {{ $Device->token }} ({{ ($Device->used ? "used" : "unused") }})
                                    </li>
                                @endforeach
                            </ul>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <input class="btn btn-success" value="Save" id="user.save" onclick="saveUser()">
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <!-- end profile -->

            <!-- org -->
            <div class="tab-pane" id="org" role="tabpanel">
                @if(!is_null(\Auth::user()->organization_id))
                    <table class="table table-condensed" id="orgStats">
                        <tbody>
                        <tr>
                            <td>Name</td>
                            <td>
                                <input id="orgName" type="text" class="form-control"
                                       value="{{ \Auth::user()->organization->name }}">
                            </td>
                        </tr>
                        <tr>
                            <td>Administrator</td>
                            <td>
                                <select id='orgAdmin' class="form-control">
                                    @foreach(\App\User::where('organization_id',\Auth::user()->organization->id)->orderBy('name')->get(['id','name']) as $User)
                                        <option value="{{ $User->id }}">{{ $User->name }}</option>
                                    @endforeach
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>Status</td>
                            <td>
                                <select id="orgStatus" class="form-control">
                                    @foreach(\App\Status::where('type','Organization')->get(['id','name']) as $Status)
                                        <option {{ (\Auth::user()->organization->status->id == $Status->id ? 'selected' : '') }} value="{{ $Status->id }}">{{ $Status->name }}</option>
                                    @endforeach
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>Manifesto</td>
                            <td>
                            <textarea id='orgManifesto' rows='6'
                                      class="form-control">{{ \Auth::user()->organization->manifesto }}</textarea>
                            </td>
                        </tr>
                        <tr>
                            <td>Founded On</td>
                            <td>
                                <input class="form-control" type="date" disabled
                                       value="{{ \Auth::user()->organization->created_at->format('Y-m-d') }}">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <button class="btn btn-success" onclick="updateOrg()">Update Org</button>
                            </td>
                            <td>
                                <div id='orgSuccess' class="alert alert-success" role="alert" style="display: none">
                                    <strong>Success</strong>
                                    <p id="orgSuccessText"></p>
                                </div>
                                <div id='orgError' class="alert alert-danger" role="alert" style="display: none">
                                    <strong>ERROR!</strong>
                                    <p id="orgErrorText"></p>
                                </div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                @endif
                <div class="col-md-6" id="orgChangeText"></div>
                <div class="col-md-6">
                    @foreach(App\Organization::with('status')->where('status_id',1)->get(['id','name','status_id']) as $Organization)
                        <div class="radio">
                            <label><input type="radio" name="joinOrg"
                                          value="{{ $Organization->id }}">{{ $Organization->name }}</label>
                        </div>
                    @endforeach
                    <button class="btn btn-success" onclick="joinOrg()">Update</button>
                </div>

            </div>
            <!-- end org -->

            @if(!is_null(\Auth::user()->organization_id))

                <!-- fleet -->
                <div class="tab-pane" id="fleet" role="tabpanel">
                    @if(!is_null(\Auth::user()->fleet_id))
                        <div class="col-md-12">
                            <table class="table table-condensed">
                                <tbody>
                                <tr>
                                    <td>Name</td>
                                    <td>{{ \Auth::user()->fleet->name }}</td>
                                </tr>
                                <tr>
                                    <td>Admiral</td>
                                    <td>{{ \Auth::user()->fleet->admiral->name }}</td>
                                </tr>
                                <tr>
                                    <td>Organization</td>
                                    <td>{{ \Auth::user()->fleet->organization->name }}</td>
                                </tr>
                                <tr>
                                    <td>Status</td>
                                    <td>{{ \Auth::user()->fleet->status->name }}</td>
                                </tr>
                                <tr>
                                    <td>Manifesto</td>
                                    <td>{{ \Auth::user()->fleet->manifesto }}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    @endif
                    <div class="col-md-6">
                        @if(is_null(\Auth::user()->fleet_id))
                            <p>You are not currently a member of a fleet</p>
                        @endif
                        <p>To update the fleet you are in, make a selection and click 'update.'</p>
                    </div>
                    <div class="col-md-6">
                        @foreach(\App\Fleet::where('organization_id',\Auth::user()->organization_id)->get(['name','id']) as $Fleet)
                            <div class="radio">
                                <label>
                                    <input type="radio" name="joinFleet" value="{{ $Fleet->id }}">{{ $Fleet->name }}
                                </label>
                            </div>
                        @endforeach
                        <button class="btn btn-success" onclick="joinFleet()">Update</button>
                    </div>
                </div>
                <!-- end fleet -->

                <!-- squad -->
                <div class="tab-pane" id="squad" role="tabpanel">
                    squad
                </div>
                <!-- end squad -->
            @endif
        </div>
    </div>


    <script>
        var Token = '{{ $token }}';
        var UserData;
        $.getJSON("/api/v4/users/{{ \Auth::user()->id }}", function (Response) {
            UserData = Response;
            if (UserData.organization_id == null) {
                $('#orgChangeText').html('<p>You are not a member of an organization.</p><p>Select an Organization to join:</p>');
            } else {
                $('#orgChangeText').html('<p>Select an Organization and click "update" to join a new Organization</p>');
            }
        });

        function joinOrg() {
            $.post(("/api/v4/users/" + UserData.id), {
                '_method': 'patch',
                'token': Token,
                'organization_id': $('input[name="joinOrg"]:checked').val()
            })
                    .done(function () {
                        location.reload();
                    });
        }

        function joinFleet() {
            $.post(("/api/v4/users/" + UserData.id), {
                '_method' : 'patch',
                'token' : Token,
                'fleet_id' : $('input[name="joinFleet"]:checked').val()
            })
                    .done(function () {
                        location.reload();
                    });
            ;
        }

        function updateOrg() {
            $.post(("/api/v4/organizations/" + UserData.organization_id), {
                '_method': 'patch',
                'token': Token,
                'name': $('#orgName').val(),
                'admin_user_id': $('#orgAdmin').val(),
                'status_id': $('#orgStatus').val(),
                'manifesto': $('#orgManifesto').val()
            })
                    .done(function () {
                        $('#orgSuccessText').text('Organization Data Saved');
                        $('#orgError').hide();
                        $('#orgSuccess').show();
                    })
                    .fail(function (Response) {
                        $('#orgErrorText').text(JSON.parse(Response.responseText).error);
                        $('#orgSuccess').hide();
                        $('#orgError').show();
                    });
        }

        function saveUser() {
            var ships = [];
            $('#userships :selected').each(function (i, selected) {
                ships[i] = $(selected).val();
            });
            $.post(("/api/v4/users/" + UserData.id), {
                'name': $("#username").text(),
                'ships[]': ships,
                '_method': 'patch',
                'token': Token
            });
        }
    </script>

@endsection