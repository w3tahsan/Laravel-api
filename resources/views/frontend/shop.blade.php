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
                        <li>Shop</li>
                    </ol>
                </div>
            </div>
        </div> <!-- end row -->
    </div> <!-- end container -->
</section>
<!-- end page-title -->

<!-- product-area-start -->
<div class="shop-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-4">
                <div class="shop-filter-wrap">
                    <div class="filter-item">
                        <div class="shop-filter-item">
                            <div class="shop-filter-search">
                                <form>
                                    <div>
                                        <input id="search_input2" type="text" class="form-control" placeholder="Search.." value="{{@$_GET['search_input']}}">
                                        <button class="search_btn2" type="button"><i class="ti-search"></i></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="filter-item">
                        <div class="shop-filter-item category-widget">
                            <div class="filter-item">
                                <div class="shop-filter-item">
                                    <h2>Filter By Category</h2>
                                    <ul>
                                        @foreach ($categories as $category)
                                        <li>
                                            <label class="topcoat-radio-button__label">
                                                {{$category->category_name}} <span>({{App\Models\Product::where('category_id', $category->id)->count()}})</span>
                                                <input {{$category->id == @$_GET['category_id']?'checked':''}} class="category" name="category_id" type="radio" value="{{$category->id}}">
                                                <span class="topcoat-radio-button"></span>
                                            </label>
                                        </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="filter-item">
                        <div class="shop-filter-item">
                            <h2>Filter by price</h2>
                            <div class="shopWidgetWraper">
                                <div class="priceFilterSlider">
                                    <form>
                                        <div class="d-flex">
                                            <div class="col-lg-6 pe-2">
                                                <label for="" class="form-label">Min</label>
                                                <input id="min" type="text" class="form-control" placeholder="Min" value="{{@$_GET['min']}}">
                                            </div>
                                            <div class="col-lg-6">
                                                <label for="" class="form-label">Max</label>
                                                <input id="max" type="text" class="form-control" placeholder="Max" value="{{@$_GET['max']}}">
                                            </div>
                                        </div>
                                        <div class="col-lg-12 mt-4">
                                            <button type="button" class="form-control bg-light range">Submit</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="filter-item">
                        <div class="shop-filter-item">
                            <h2>Color</h2>
                            <ul>
                                @foreach ($colors as $color)
                                <li>
                                    <label class="topcoat-radio-button__label">
                                        {{$color->color_name}} <span>({{App\Models\Inventory::where('color_id', $color->id)->count()}})</span>
                                        <input {{$color->id == @$_GET['color_id']?'checked':''}} class="color" type="radio" name="color_id" value="{{$color->id}}">
                                        <span class="topcoat-radio-button"></span>
                                    </label>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <div class="filter-item">
                        <div class="shop-filter-item">
                            <h2>Size</h2>
                            <ul>
                                @foreach ($sizes as $size)
                                <li>
                                    <label class="topcoat-radio-button__label">
                                        {{$size->size_name}} <span>({{App\Models\Inventory::where('size_id', $size->id)->count()}})</span>
                                        <input {{$size->id == @$_GET['size_id']?'checked':''}} class="size" type="radio" name="size_id" value="{{$size->id}}">
                                        <span class="topcoat-radio-button"></span>
                                    </label>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <div class="filter-item">
                        <div class="shop-filter-item tag-widget">
                            <h2>Popular Tags</h2>
                            <ul>
                                @foreach ($tags as $tag)
                                    <li><button value="{{$tag->id}}" class="btn btn-light tag {{$tag->id == @$_GET['tag']?'text-danger':''}}">{{$tag->tag_name}}</button></li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="shop-section-top-inner">
                    <div class="shoping-product">
                        <p>We found <span>{{$products->count()}} items</span> for you!</p>
                    </div>
                    <div class="short-by">
                        <ul>
                            <li>
                                Sort by:
                            </li>
                            <li>
                                <select name="sort" class="sort">
                                    <option value="">Default Sorting</option>
                                    <option {{@$_GET['sort'] == 1?'selected':''}} value="1">Price Low To High</option>
                                    <option {{@$_GET['sort'] == 2?'selected':''}} value="2">Price High To Low</option>
                                    <option {{@$_GET['sort'] == 3?'selected':''}} value="3">Name (A-Z)</option>
                                    <option {{@$_GET['sort'] == 4?'selected':''}} value="4">Name (Z-A)</option>
                                </select>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="product-wrap">
                    <div class="row align-items-center">
                        @forelse ($products as $product)
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
            </div>
        </div>
    </div>
</div>
<!-- product-area-end -->
@endsection
@section('footer_script')

@endsection
