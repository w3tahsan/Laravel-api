@extends('frontend.master')

@section('content')
@include('bread')
   <!-- product-single-section  start-->
   <div class="product-single-section section-padding">
    <div class="container">
        <div class="product-details">
            <form action="{{ route('add.cart') }}" method="POST">
                @csrf
                <div class="row align-items-center">
                    <div class="col-lg-5">
                        <div class="product-single-img">
                            <div class="product-active owl-carousel">
                                @foreach ($gallery as $gal)
                                <div class="item">
                                    <img height="550" src="{{asset('uploads/product/gallery')}}/{{$gal->gallery}}" alt="">
                                </div>
                                @endforeach
                            </div>
                            <div class="product-thumbnil-active  owl-carousel">
                                @foreach ($gallery as $gal)
                                <div class="item">
                                    <img height="150" src="{{asset('uploads/product/gallery')}}/{{$gal->gallery}}" alt="">
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @php
                        $avg = '';
                        if($total_reviews == 0){
                            $avg = 0;
                        }
                        else{
                            $avg = round($total_stars/$total_reviews);
                        }
                    @endphp
                    <div class="col-lg-7">
                        <div class="product-single-content">
                            <h2>{{$product_info->product_name}}</h2>
                            <div class="price">
                                <span class="present-price">&#2547;{{$product_info->after_discount}}</span>
                                @if ($product_info->discount)
                                    <del class="old-price">&#2547;{{$product_info->price}}</del>
                                @endif
                            </div>
                            <div class="rating-product">
                                @for ($i=1; $i<=$avg; $i++)
                                    <i class="fa fa-star"></i>
                                @endfor
                                @for ($i=$avg; $i<=4; $i++)
                                    <i class="fa fa-star-o"></i>
                                @endfor
                                <span>{{$total_reviews}}</span>
                            </div>
                            <p>{{$product_info->short_desp}}
                            </p>
                            <div class="product-filter-item color">
                                <div class="color-name">
                                    <span>Color :</span>
                                    <ul>
                                        @foreach ($available_colors as $colors)
                                        @if ($colors->rel_to_color->color_name == 'NA')
                                        <li class="color"><input class="color_id" checked id="color{{$colors->color_id}}" type="radio" name="color_id" value="{{$colors->color_id}}">
                                            <label for="color{{$colors->color_id}}" style="background: {{$colors->rel_to_color->color_code}}">NA</label>
                                        </li>
                                        @else
                                        <li class="color1"><input class="color_id" id="color{{$colors->color_id}}" type="radio" name="color_id" value="{{$colors->color_id}}">
                                            <label for="color{{$colors->color_id}}" style="background: {{$colors->rel_to_color->color_code}}"></label>
                                        </li>
                                        @endif
                                        @endforeach
                                    </ul>
                                    @error('color_id')
                                        <strong class="text-danger">Color is Required</strong>
                                    @enderror
                                </div>
                            </div>
                            <div class="product-filter-item color filter-size">
                                <div class="color-name">
                                    <span>Sizes:</span>
                                    <ul class="size_aval">
                                        @foreach ($available_sizes as $size)
                                        @if ($size->rel_to_size->size_name == 'NA')
                                         <li class="color"><input checked class="size_id" id="size{{$size->size_id}}" type="radio" name="size_id" value="{{$size->size_id}}">
                                            <label for="size{{$size->size_id}}">{{$size->rel_to_size->size_name}}</label>
                                        </li>
                                        @else
                                         <li class="color"><input class="size_id" id="size{{$size->size_id}}" type="radio" name="size_id" value="{{$size->size_id}}">
                                            <label for="size{{$size->size_id}}">{{$size->rel_to_size->size_name}}</label>
                                        </li>
                                        @endif

                                        @endforeach
                                    </ul>
                                    @error('size_id')
                                        <strong class="text-danger">Size is Required</strong>
                                    @enderror
                                </div>
                            </div>
                            <div class="pro-single-btn">
                                <div class="quantity cart-plus-minus">
                                    <input class="text-value" name="quantity" type="text" value="1">
                                </div>
                                @auth('customer')
                                <button type="submit" class="theme-btn-s2">Add to cart</button>
                                @else
                                    <a href="{{ route('customer.login') }}" class="theme-btn-s2">Add to cart</a>
                                @endauth
                                <a href="#" class="wl-btn"><i class="fi flaticon-heart"></i></a>
                            </div>
                            <input type="hidden" name="product_id" value="{{ $product_info->id }}">
                            <ul class="important-text">
                                <li><span>SKU:</span>FTE569P</li>
                                <li><span>Categories:</span> {{$product_info->rel_to_cat->category_name}}</li>
                                @php
                                    $after_explode = explode(',', $product_info->tags);
                                @endphp
                                <li><span>Tags:</span>
                                    @foreach ($after_explode as $tag)
                                        <a href="{{route('tag.product', $tag)}}" class="badge bg-warning text-dark">{{App\Models\Tag::find($tag)->tag_name}}</a>
                                    @endforeach
                                </li>
                                <li class="mt-1" id="quan"></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="product-tab-area">
            <ul class="nav nav-mb-3 main-tab" id="tab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="descripton-tab" data-bs-toggle="pill"
                        data-bs-target="#descripton" type="button" role="tab" aria-controls="descripton"
                        aria-selected="true">Description</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="Ratings-tab" data-bs-toggle="pill" data-bs-target="#Ratings"
                        type="button" role="tab" aria-controls="Ratings" aria-selected="false">Reviews
                        (3)</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="Information-tab" data-bs-toggle="pill"
                        data-bs-target="#Information" type="button" role="tab" aria-controls="Information"
                        aria-selected="false">Additional info</button>
                </li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane fade show active" id="descripton" role="tabpanel"
                    aria-labelledby="descripton-tab">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="Descriptions-item">
                                    {!!$product_info->long_desp!!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="Ratings" role="tabpanel" aria-labelledby="Ratings-tab">
                    <div class="container">
                        <div class="rating-section">
                            <div class="row">
                                <div class="col-lg-12 col-12">
                                    <div class="comments-area">
                                        <div class="comments-section">
                                            <h3 class="comments-title">3 reviews for Stylish Pink Coat</h3>
                                            <ol class="comments">
                                                @foreach ($reviews as $review)


                                                <li class="comment even thread-even depth-1" id="comment-1">
                                                    <div id="div-comment-1">
                                                        <div class="comment-theme">
                                                            <div class="comment-image">
                                                                @if ($review->rel_to_customer->photo == null)
                                                                    <img width="70" class="m-auto" src="{{ Avatar::create($review->rel_to_customer->fname.' '. $review->rel_to_customer->lname)->toBase64() }}" />
                                                                @else
                                                                    <img width="70" class="m-auto" src="{{asset('uploads/customer')}}/{{$review->rel_to_customer->photo}}"/>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="comment-main-area">
                                                            <div class="comment-wrapper">
                                                                <div class="comments-meta">
                                                                    <h4>{{$review->rel_to_customer->fname.' '.$review->rel_to_customer->lname}}</h4>
                                                                    <span class="comments-date">{{$review->updated_at->diffForHumans()}}</span>
                                                                    <div class="rating-product">
                                                                        @for ($i=1; $i<=$review->star; $i++)
                                                                        <i class="fa fa-star"></i>
                                                                        @endfor
                                                                        @for ($i=$review->star; $i<=4; $i++)
                                                                            <i class="fa fa-star-o"></i>
                                                                        @endfor
                                                                    </div>
                                                                </div>
                                                                <div class="comment-area">
                                                                    <p>
                                                                        {{$review->review}}
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>
                                                @endforeach
                                            </ol>
                                        </div> <!-- end comments-section -->
                                        @auth('customer')
                                            @if (App\Models\OrderProduct::where('customer_id', Auth::guard('customer')->id())->where('product_id', $product_info->id)->exists())
                                                @if (App\Models\OrderProduct::where('customer_id', Auth::guard('customer')->id())->whereNotNull('review')->first() == false)
                                                <div class="col col-lg-10 col-12 review-form-wrapper">
                                                    <div class="review-form">
                                                        <h4>Add a review</h4>
                                                        <form action="{{route('review.store', $product_info->id)}}" method="POST">
                                                            @csrf
                                                            <div class="give-rat-sec">
                                                                <div class="give-rating">
                                                                    <label>
                                                                        <input type="radio" name="stars" value="1">
                                                                        <span class="icon">★</span>
                                                                    </label>
                                                                    <label>
                                                                        <input type="radio" name="stars" value="2">
                                                                        <span class="icon">★</span>
                                                                        <span class="icon">★</span>
                                                                    </label>
                                                                    <label>
                                                                        <input type="radio" name="stars" value="3">
                                                                        <span class="icon">★</span>
                                                                        <span class="icon">★</span>
                                                                        <span class="icon">★</span>
                                                                    </label>
                                                                    <label>
                                                                        <input type="radio" name="stars" value="4">
                                                                        <span class="icon">★</span>
                                                                        <span class="icon">★</span>
                                                                        <span class="icon">★</span>
                                                                        <span class="icon">★</span>
                                                                    </label>
                                                                    <label>
                                                                        <input type="radio" name="stars" value="5">
                                                                        <span class="icon">★</span>
                                                                        <span class="icon">★</span>
                                                                        <span class="icon">★</span>
                                                                        <span class="icon">★</span>
                                                                        <span class="icon">★</span>
                                                                    </label>
                                                                </div>

                                                            </div>
                                                            @error('stars')
                                                                    <strong class="text-danger">{{$message}}</strong>
                                                            @enderror
                                                            <div>
                                                                <textarea required name="review" class="form-control"
                                                                    placeholder="Write Comment..."></textarea>
                                                                @error('review')
                                                                    <strong class="text-danger">{{$message}}</strong>
                                                                @enderror
                                                            </div>
                                                            <div class="name-input">
                                                                <input type="text" class="form-control" placeholder="Name" value="{{Auth::guard('customer')->user()->fname}}">
                                                            </div>
                                                            <div class="name-email">
                                                                <input type="email" class="form-control" placeholder="Email"
                                                                value="{{Auth::guard('customer')->user()->email}}">
                                                            </div>

                                                            <div class="rating-wrapper">
                                                                <div class="submit">
                                                                    <button type="submit" class="theme-btn-s2">Post
                                                                        review</button>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                                @else
                                                <h3 class="alert alert-warning">You Already Reviewed this product</h3>
                                                @endif
                                            @else
                                                <h3 class="alert alert-warning">You did not purchase this product yet</h3>
                                            @endif
                                        @endauth
                                    </div> <!-- end comments-area -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="Information" role="tabpanel" aria-labelledby="Information-tab">
                    <div class="container">
                        <div class="Additional-wrap">
                            <div class="row">
                                <div class="col-12">
                                    {!!$product_info->addi_info!!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="related-product">
    </div>
</div>
<!-- product-single-section  end-->
@endsection

@section('footer_script')
<script>
    $('.color_id').click(function(){
        var color_id = $(this).val();
        var product_id = '{{$product_info->id}}';

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url:'/getSize',
            type:'POST',
            data:{'color_id':color_id, 'product_id':product_id},
            success: function (data) {
                $('.size_aval').html(data);

                $('.size_id').click(function(){
                    var size_id = $(this).val();
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    $.ajax({
                        url:'/getQuantity',
                        type:'POST',
                        data:{'color_id':color_id, 'product_id':product_id, 'size_id':size_id},
                        success: function (data) {
                            $('#quan').html(data);
                        }
                    });

                });
            }

        });
    })
</script>
@if (session('cart_added'))
<script>
    Swal.fire({
        position: 'top-right',
        icon: 'success',
        title: '{{ session('cart_added') }}',
        showConfirmButton: false,
        timer: 1500
    })
</script>
@endif
@endsection
