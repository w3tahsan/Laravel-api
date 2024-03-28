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
                        <li><a href="product.html">Customer Profile</a></li>
                    </ol>
                </div>
            </div>
        </div> <!-- end row -->
    </div> <!-- end container -->
</section>
<!-- end page-title -->
<div class="container">
    <div class="row py-5">
        @include('frontend.includes.profile_sidebar')
        <div class="col-lg-9">
            <div class="card">
                <div class="card-header">
                    <h3>Update Customer Information</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="" class="form-label">First Name</label>
                                    <input type="text" name="fname" class="form-control" value="{{ Auth::guard('customer')->user()->fname }}">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="" class="form-label">Last Name</label>
                                    <input type="text" name="lname" class="form-control" value="{{ Auth::guard('customer')->user()->lname }}">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="" class="form-label">Email</label>
                                    <input type="text" disabled class="form-control" value="{{ Auth::guard('customer')->user()->email }}">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="" class="form-label">Password</label>
                                    <input type="password" name="password" class="form-control">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="" class="form-label">Phone</label>
                                    <input type="text" name="phone" class="form-control" value="{{ Auth::guard('customer')->user()->phone }}">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="" class="form-label">Zip</label>
                                    <input type="number" name="zip" class="form-control" value="{{ Auth::guard('customer')->user()->zip }}">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="" class="form-label">Address</label>
                                    <input type="text" name="address" class="form-control" value="{{ Auth::guard('customer')->user()->address }}">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="" class="form-label">image</label>
                                    <input type="file" name="image" class="form-control">
                                    <img width="100" src="{{ asset('uploads/customer') }}/{{ Auth::guard('customer')->user()->photo }}" alt="">
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="mb-3 text-center mt-3">
                                    <button class="btn btn-primary" type="submit">Update</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
