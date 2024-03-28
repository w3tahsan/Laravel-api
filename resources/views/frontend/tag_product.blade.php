@extends('frontend.master')
@section('content')
<div class="container my-5">
    <div class="row align-items-center">
        @forelse ($tag_products as $product)
            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-12">
                <div class="product-item">
                    <div class="image">
                        <img height="200" src="{{asset('/uploads/product/preview')}}/{{$product->preview}}" alt="">
                        <div class="tag new">New</div>
                    </div>
                    <div class="text">
                        <h2><a href="{{route('product.details', $product->slug)}}">{{$product->product_name}}</a></h2>
                        <div class="rating-product">
                            <i class="fi flaticon-star"></i>
                            <i class="fi flaticon-star"></i>
                            <i class="fi flaticon-star"></i>
                            <i class="fi flaticon-star"></i>
                            <i class="fi flaticon-star"></i>
                            <span>130</span>
                        </div>
                        <div class="price">
                            <span class="present-price">&#2547;{{$product->after_discount}}</span>
                            <del class="old-price">&#2547;{{$product->price}}</del>
                        </div>
                        <div class="shop-btn">
                            <a class="theme-btn-s2" href="{{route('product.details', $product->slug)}}">Shop Now</a>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <h3>No Search Product Found</h3>
        @endforelse
    </div>
</div>
@endsection
