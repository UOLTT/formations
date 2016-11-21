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
                        <td>
                            Name
                        </td>
                        <td>
                            <input type="text" name="name" id="username" class="form-control" value="{{ \Auth::user()->name }}">
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
                        <td colspan="2">
                            <input class="btn btn-success" value="Save" id="user.save" onclick="saveUser()">
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <!-- end profile -->

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
        var UserData;
        $.getJSON("/api/v4/users/{{ \Auth::user()->id }}", function (Response) {
            UserData = Response;
        });

        function saveUser() {
            var ships = [];
            $('#userships :selected').each(function(i, selected){
                ships[i] = $(selected).val();
            });
            $.post(("/api/v4/users/" + UserData.id), {
                'name' : $("#username").text(),
                'ships[]' : ships,
                '_method' : 'patch',
                'token' : 'abcdef'
            });
        }
    </script>

@endsection