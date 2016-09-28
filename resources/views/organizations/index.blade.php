@extends('layouts.main')

@section('content')

    <div class="page-header">
        <h1>Organizations</h1>
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
                @foreach(\App\Organization::withCount('users')->with('status')->get() as $Org)
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