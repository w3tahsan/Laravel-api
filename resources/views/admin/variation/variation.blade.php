@extends('layouts.admin')
@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="card bg-light">
            <div class="card-header">
                <h3>Color List</h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th>Color Name</th>
                        <th>Color</th>
                        <th>Action</th>
                    </tr>
                    @foreach ($colors as $color)                        
                    <tr>
                        <td>{{$color->color_name}}</td>
                        <td>
                            <i style="display:inline-block; width:30px; height:30px; background:{{$color->color_name == 'NA'?'':$color->color_code}}; color:{{$color->color_name == 'NA'?'':'transparent'}}">{{$color->color_name == 'NA'?$color->color_name:'Color'}}</i>
                        </td>
                        <td>
                            <a href="" class="btn btn-danger">Delete</a>
                        </td>
                    </tr>
                    @endforeach
                </table>
            </div>
        </div>
        <div class="card mt-4">
            <div class="card-header">
                <h3>Size List</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    @foreach ($categories as $category)
                    <div class="col-lg-6">
                        <div class="card mt-2">
                            <div class="card-header">
                                <h5>{{$category->category_name}}</h5>
                            </div>
                            <div class="card-body">
                                <table class="table table-bordered">
                                    <tr>
                                        <th>Size Name</th>
                                        <th>Action</th>
                                    </tr>
                                    @foreach (App\Models\Size::where('category_id', $category->id)->get() as $size)                                        
                                    <tr>
                                        <td>{{$size->size_name}}</td>
                                        <td><a href="" class="btn btn-danger">Delete</a></td>
                                    </tr>
                                    @endforeach
                                </table>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h3>Add Color</h3>
            </div>
            <div class="card-body">
                <form action="{{route('color.store')}}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="" class="form-label">Color Name</label>
                        <input type="text" name="color_name" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Color Code</label>
                        <input type="text" name="color_code" class="form-control">
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary">Add Color</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="card mt-3">
            <div class="card-header">
                <h3>Add Size</h3>
            </div>
            <div class="card-body">
                <form action="{{route('size.store')}}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <select name="category_id" class="form-control">
                            <option value="">Select Category</option>
                            @foreach ($categories as $category)                            
                                <option value="{{$category->id}}">{{$category->category_name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Size Name</label>
                        <input type="text" name="size_name" class="form-control">
                    </div>

                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary">Add Color</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection