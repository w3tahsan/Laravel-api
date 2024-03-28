@extends('layouts.admin')
@section('content')
@can('order_cancel_list')
<div class="row">
    <div class="col-lg-8 m-auto">
        <div class="card">
            <div class="card-header">
                <h3>Order Cancel List</h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th>SL</th>
                        <th>Order ID</th>
                        <th>Action</th>
                    </tr>
                    @foreach ($order_cancel_lists as $sl=>$cancel_list)
                    <tr>
                        <td>{{$sl+1}}</td>
                        <td>{{App\Models\Order::find($cancel_list->order_id)->order_id}}</td>
                        <td>
                            <a href="{{route('cancel.details', $cancel_list->id)}}" class="btn btn-info text-white">View</a>
                            <a href="{{route('cancel.accept', $cancel_list->id)}}" class="btn btn-success  text-white">Accept</a>
                        </td>
                    </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
</div>
@endcan
@endsection
