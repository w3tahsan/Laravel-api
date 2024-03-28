@extends('layouts.admin')
@section('content')
<div class="row">
    <div class="col-lg-6 ">
        <div class="card">
            <div class="card-header">
                <h3>Offer 1</h3>
            </div>
            <div class="card-body">
                <form action="{{route('offer1.update', $offer->first()->id)}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="aaa" class="form-label">Title</label>
                        <input id="aaa" type="text" name="title" class="form-control" value="{{$offer->first()->title}}">
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Price</label>
                        <input type="number" name="price" class="form-control" value="{{$offer->first()->price}}">
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Discount Price</label>
                        <input type="number" name="discount_price" class="form-control" value="{{$offer->first()->discount_price}}">
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Image</label>
                        <input type="file" name="image" class="form-control" onchange="document.getElementById('blah').src = window.URL.createObjectURL(this.files[0])">
                        <div class="my-2">
                            <img id="blah" width="200" src="{{asset('uploads/offer')}}/{{$offer->first()->image}}" alt="">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Date</label>
                        <input type="date" name="date" class="form-control" value="{{$offer->first()->date}}">
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn  btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-lg-6 ">
        <div class="card">
            <div class="card-header">
                <h3>Offer 2</h3>
            </div>
            <div class="card-body">
                <form action="{{route('offer2.update', $offer2->first()->id)}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="aaa" class="form-label">Title</label>
                        <input id="aaa" type="text" name="title" class="form-control" value="{{$offer2->first()->title}}">
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Subtitle</label>
                        <input type="text" name="subtitle" class="form-control" value="{{$offer2->first()->subtitle}}">
                    </div>
                    
                    <div class="mb-3">
                        <label for="" class="form-label">Image</label>
                        <input type="file" name="image" class="form-control" onchange="document.getElementById('blah2').src = window.URL.createObjectURL(this.files[0])">
                        <div class="my-2">
                            <img id="blah2" width="200" src="{{asset('uploads/offer')}}/{{$offer2->first()->image}}" alt="">
                        </div>
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn  btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection