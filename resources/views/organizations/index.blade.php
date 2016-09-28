@extends('layouts.main')

@section('content')

    <div class="page-header">
        <h1>Organizations</h1>
    </div>

    <div class="row">
        <div class="col-md-12">
            <a data-toggle="collapse" data-target="#search">Search For Organization</a>
        </div>
    </div>

    <div id="search" class="row collapse">
        <br>
        <div class="col-md-12">
            <form action="" method="get">
                <div class="col-md-3">
                    <b>Name:</b>
                    <input class="form-control" type="text" name="name">
                </div>
                <div class="col-md-3">
                    <b>Status:</b>
                    <select name="status" class="form-control">
                        <option></option>
                        @foreach(\App\Status::where('type','Organization')->get() as $Status)
                            <option value="{{ $Status->id }}">{{ $Status->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <b>Min. Users:</b>
                    <input type="number" class="form-control" name="userCountMin" min="0">
                </div>
                <div class="col-md-2">
                    <b>Max. Users:</b>
                    <input type="number" class="form-control" name="userCountMax" min="0">
                </div>
                <div class="col-md-2">
                    <br>
                    <input type="submit" class="btn btn-primary" value="Search">
                </div>
            </form>
        </div>
        <br><br>
    </div>

    <div class="row">
        <div class="col-md-12">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Created On</th>
                    <th>Status</th>
                    <th>User Count</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach(\App\Organization::withCount('users')->with('status')->orderBy('users_count','desc')->get() as $Org)
                    <tr>
                        <td>{{ $Org->name }}</td>
                        <td>{{ $Org->created_at->format('m/d/Y') }}</td>
                        <td>{{ $Org->status->name }}</td>
                        <td>{{ $Org->users_count }}</td>
                        <td>
                            <button class="btn btn-info">Info</button>
                            @if($Org->status->name == 'Open')
                                <button class="btn btn-success">Join Now</button>
                            @elseif($Org->status->name == 'Accepting Applicants')
                                <button class="btn btn-warning">Apply to Join</button>
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection