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
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title">{{ \Auth::user()->organization->name }}</h3>
                    </div>
                    <div class="panel-body">
                        Organization Status:<br>
                    </div>
                </div>
            @endif
        </div>

    @endif

@endsection