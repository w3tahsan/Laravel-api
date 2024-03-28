@extends('frontend.master')
@section('content')
<!-- start wpo-page-title -->
<section class="wpo-page-title">
    <h2 class="d-none">Hide</h2>
    <div class="container">
        <div class="row">
            <div class="col col-xs-12">
                <div class="wpo-breadcumb-wrap">
                    <ol class="wpo-breadcumb-wrap">
                        <li><a href="index.html">Home</a></li>
                        <li><a href="product.html">My Orders</a></li>
                    </ol>
                </div>
            </div>
        </div> <!-- end row -->
    </div> <!-- end container -->
</section>
<!-- end page-title -->

<section>
    <div class="container">
        <div class="row py-5">
            @include('frontend.includes.profile_sidebar')
            <div class="col-lg-9">
                <div class="card">
                    <div class="card-header">
                        <h3>My Order Lists</h3>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <tr>
                                <th>SL</th>
                                <th>Order ID</th>
                                <th>Total</th>
                                <th>Order Date</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                            @foreach ($my_orders as $my_order)
                            <tr>
                                <td>{{$loop->index+1}}</td>
                                <td>{{$my_order->order_id}}</td>
                                <td>{{$my_order->total}}</td>
                                <td>{{$my_order->created_at->format('d-M-Y')}}</td>
                                <td>
                                    @if ($my_order->status == 0)
                                        <span class="badge bg-secondary">Placed</span>
                                    @elseif ($my_order->status == 1)
                                        <span class="badge bg-primary">Processing</span>
                                    @elseif ($my_order->status == 2)
                                        <span class="badge bg-warning">Shipping</span>
                                    @elseif ($my_order->status == 3)
                                        <span class="badge bg-info">Ready For Deliver</span>
                                    @elseif ($my_order->status == 4)
                                        <span class="badge bg-success">Received</span>
                                    @elseif ($my_order->status == 5)
                                        <span class="badge bg-danger">Cancel</span>
                                    @endif
                                </td>
                                <td>
                                    @if (App\Models\OrderCancel::where('order_id', $my_order->id)->exists())
                                    <a class="btn btn-warning">Cancel Request Pending</a>
                                    @else
                                        @if ($my_order->status == 5)
                                        <a class="btn btn-warning">Canceled</a>
                                        @else
                                        <a href="{{route('cancel.order', $my_order->id)}}" class="btn btn-danger">Cancel Order</a>
                                        @endif
                                    @endif

                                        @if ($my_order->status == 5)
                                        @else
                                        <a target="_blank" href="{{route('download.invoice', $my_order->id)}}" class="btn btn-info">Download Invoice</a>
                                        @endif

                                </td>
                            </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
