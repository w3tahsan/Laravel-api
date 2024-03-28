@extends('frontend.master')


@section('content')
<div class="container my-5">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h3>Category From API</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        @foreach ($categories as $category)
                        <div class="col-lg-4 my-2">
                            <div class="card">
                                <div class="card-header">
                                    {{$category->category_name}}
                                </div>
                                <div class="card-body">
                                    <img src="{{env('CATEGORY_IMAGE')}}/{{$category->icon}}" alt="">
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
