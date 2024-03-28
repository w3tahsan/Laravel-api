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
                        <li><a href="product.html">Order Success</a></li>
                    </ol>
                </div>
            </div>
        </div> <!-- end row -->
    </div> <!-- end container -->
</section>
<!-- end page-title -->

<div class="container">
    <div class="row my-5">
        <div class="col-lg-8 m-auto">
            <div class="card">
                <div class="card-header">Order ID: {{ session('success') }}</div>
                <div class="card-body">
                    <img src="{{ asset('frontend/images/order.png') }}" alt="">
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

