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
                @if(is_null(\Auth::user()->organization))
                    <div class="col-md-6">
                        <p>You are not a member of an organization.</p>
                        <p>Select an Organization to join:</p>
                    </div>
                    <div class="col-md-6">
                        @foreach(App\Organization::with('status')->where('status_id',1)->get(['id','name','status_id']) as $Organization)
                            <div class="radio">
                                <label><input type="radio" name="joinOrg" value="{{ $Organization->id }}">{{ $Organization->name }}</label>
                            </div>
                        @endforeach
                        <button class="btn btn-success" onclick="joinOrg()">Join</button>
                    </div>
                @endif
            </div>
            <!-- end org -->

            <div class="tab-pane" id="fleet" role="tabpanel">
                fleet
            </div>
            <div class="tab-pane" id="squad" role="tabpanel">
                squad
            </div>
        </div>
    </div>


    <script>
        var Token = '{{ $token }}';
        var UserData;
        $.getJSON("/api/v4/users/{{ \Auth::user()->id }}", function (Response) {
            UserData = Response;
        });

        function joinOrg() {
            $.post(("/api/v4/users/" + UserData.id), {
                '_method' : 'patch',
                'token' : Token,
                'organization_id' : $('input[name="joinOrg"]:checked').val()
            })
                    .done(function(response) {
                        if (!'error' in response) {

                        }
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