@extends('layouts.admin')
@section('content')
<div class="row">
    <div class="col-lg-8 m-auto">
        <div class="card">
            <div class="card-header">
                <h3>Order Cancel List</h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <td>ID:</td>
                        <td>{{App\Models\Order::find($details->order_id)->order_id}}</td>
                    </tr>
                    <tr>
                        <td>Reason:</td>
                        <td>{{$details->reason}}</td>
                    </tr>
                    <tr>
                        <td>Images:</td>
                        <td>
                            <img width="200" src="{{asset('uploads/cancelorder')}}/{{$details->image}}" alt="">
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
