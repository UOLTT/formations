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
                @foreach(\App\Organization::withCount('users')->get() as $Org)
                    <tr>
                        <td>{{ $Org->name }}</td>
                        <td>{{ $Org->created_at->format('m/d/Y') }}</td>
                        <td>// TODO</td>
                        <td>{{ $Org->users_count }}</td>
                        <td>
                            <button class="btn btn-info">Info</button>
                            <button class="btn btn-success">Join</button>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <pre>
        {{ print_r(\App\Organization::all()->toArray()) }}
    </pre>

@endsection