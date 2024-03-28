@extends('layouts.admin')
@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h3>Log Info</h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th>User</th>
                        <th>Model</th>
                        <th>Data</th>
                        <th>Action</th>
                        <th>Time</th>
                    </tr>
                    @foreach ($logs as $log)
                    <tr>
                        <td>{{$log->rel_to_user->name}}</td>
                        <td>{{$log->model}}</td>
                        <td>{{$log->data}}</td>
                        <td>{{$log->action}}</td>
                        <td>{{$log->created_at->diffForHumans()}}</td>
                    </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
