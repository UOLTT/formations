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
            <!-- TODO fix when implementing group permissions -->
            @if(\Auth::user()->organization->admin_user_id == \Auth::user()->id)
                <div class="col-md-4">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h3 class="panel-title">{{ \Auth::user()->organization->name }}</h3>
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
            @endif

        <!-- TODO fix when implementing group permissions -->
        @if(\Auth::user()->fleet->admiral_id == \Auth::user()->id)
                <div class="col-md-4">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h3 class="panel-title">{{ \Auth::user()->fleet->name }}</h3>
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
            @endif
        </div>

        <script>
            var Token = "{{ $token }}";
            $('#orgStatus').on('change', function() {
                console.log({
                    token: Token,
                    _method: "patch",
                    status_id: Number(this.value)
                });
                $.post( "/api/v4/organizations/{{ \Auth::user()->organization_id }}", {
                    token: Token,
                    _method: "patch",
                    status_id: Number(this.value)
                } );
            });
            $('#fleetStatus').on('change', function() {
                console.log({
                    token: Token,
                    _method: "patch",
                    status_id: Number(this.value)
                });
                $.post( "/api/v4/fleets/{{ \Auth::user()->fleet_id }}", {
                    token: Token,
                    _method: "patch",
                    status_id: Number(this.value)
                } );
            })
        </script>

    @endif

@endsection