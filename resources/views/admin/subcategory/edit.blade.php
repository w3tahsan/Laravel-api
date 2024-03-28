@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col-lg-6 m-auto">
        <div class="card">
            <div class="card-header">
                <h3>Add New Sub Category</h3>
            </div>
            <div class="card-body">
                <form action="{{route('sub.category.update', $subcategory->id)}}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <select name="category" class="form-control">
                            <option value="">Select Category</option>
                            @foreach ($categories as $category)                                
                                <option {{$subcategory->category_id == $category->id?'selected':''}} value="{{$category->id}}">{{$category->category_name}}</option>
                            @endforeach
                        </select>
                        @error('category')
                            <strong class="text-danger">{{$message}}</strong>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Subcategory Name</label>
                        <input type="text" name="sub_category" class="form-control" value="{{$subcategory->sub_category}}">
                        @error('sub_category')
                            <strong class="text-danger">{{$message}}</strong>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary">Add Subcategory</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection