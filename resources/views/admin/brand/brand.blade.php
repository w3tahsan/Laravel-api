@extends('layouts.admin')
@section('content')
@can('brand_access')
<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h3>Brand List</h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th>Brand Name</th>
                        <th>Brand Logo</th>
                        <th>Action</th>
                    </tr>
                    @foreach ($brands as $brand)
                    <tr>
                        <td>{{$brand->brand_name}}</td>
                        <td>
                            <img width="100" src="{{asset('uploads/brand')}}/{{$brand->brand_logo}}" alt="">
                        </td>
                        <td>
                            @can('brand_delete')
                            <a href="" class="btn btn-danger"> Delete </a>
                            @endcan
                        </td>
                    </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
    @can('brand_add')
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h3>Add New Brand</h3>
            </div>
            <div class="card-body">
                <form action="{{route('brand.store')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="" class="form-label">Brand Name</label>
                        <input type="text" name="brand_name" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Brand Logo</label>
                        <input type="file" name="brand_logo" class="form-control">
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary">Add Brand</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endcan
</div>

@endcan
@endsection
