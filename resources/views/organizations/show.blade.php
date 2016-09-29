@extends('layouts.main')

@section('content')

    <div class="page-header">
        <h1>{{ $Organization->name }}</h1>
    </div>

    <div class="row">
        <div class="col-md-6">
            <table class="table table-striped">
                <tbody>
                <tr>
                    <td><b>Organization Manager:</b></td>
                    <td>{{ $Organization->administrator->name }}</td>
                </tr>
                <tr>
                    <td><b>Management URL:</b></td>
                    <td>{{ env('APP_URL').'/'.$Organization->domain.'/' }}</td>
                </tr>
                <tr>
                    <td><b>Users:</b></td>
                    <td>{{ $Organization->users_count }}</td>
                </tr>
                <tr>
                    <td><b>Fleets:</b></td>
                    <td>{{ $Organization->fleets_count }}</td>
                </tr>
                <tr>
                    <td><b>Squadrons:</b></td>
                    <td>{{ $Organization->squads_count }}</td>
                </tr>
                </tbody>
            </table>
        </div>
        <div class="col-md-6">
            <h4>Manifesto:</h4>
            <p>{{ str_replace('\r\n','<br><br>',$Organization->manifesto) }}</p>
        </div>
    </div>

    <div class="page-header">
        <h1>Fleets:</h1>
    </div>

    @foreach($Organization->fleets as $Fleet)
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title">{{ $Fleet->name }}</h3>
                    </div>
                    <div class="panel-body">
                        {{ str_replace('\r\n',"<br><br>",$Fleet->manifesto) }}
                        <br><br>
                        @foreach($Fleet->squads as $Squad)
                            <div class="col-md-3">
                                <div class="panel panel-success">
                                    <div class="panel-heading">
                                        <h3 class="panel-title">{{ $Squad->name }}</h3>
                                    </div>
                                    <div class="panel-body">
                                        <p>
                                            <b>Users:</b> {{ $Squad->users->count() }}<br>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    @endforeach

@endsection