@extends('layouts.main')

@section('content')

    <div class="page-header">
        <h1>{{ $Organization->name }}</h1>
    </div>

    <div class="row">
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

@endsection