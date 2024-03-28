@extends('frontend.master')

@section('content')
<div class="row py-5">
    <div class="col-lg-8 m-auto">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h3 class="">Order Cancel Request </h3>
                <h4 class="bg-info p-2 text-white d-inline-block">Order ID: {{$order_info->order_id}}</h4>
            </div>
            <div class="card-body">
                @if (session('req'))
                    <div class="alert alert-success">{{session('req')}}</div>
                @endif
                <form action="{{route('cancel.order.req', $order_info->id)}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="" class="form-label">Cancel Reason</label>
                        <textarea name="reason" class="form-control" cols="30" rows="10"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Images</label>
                        <input type="file" name="image" class="form-control">
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary">Send Request</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
