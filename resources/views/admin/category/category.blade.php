@extends('layouts.admin')
@section('content')
<div class="row">
@can('category_access')
<div class="col-lg-8">
    <form action="{{route('checked.delete')}}" method="POST">
        @csrf
        <div class="card">
            <div class="card-header">
                <h3>Category List</h3>
            </div>
            <div class="card-body">
                @if (session('soft_delete'))
                    <div class="alert alert-success">{{session('soft_delete')}}</div>
                @endif
                <table class="table table-bordered">
                    <tr>
                        <th>
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input type="checkbox" id="chkSelectAll" class="form-check-input">
                                    Check All
                                <i class="input-frame"></i></label>
                            </div>
                        </th>
                        <th>SL</th>
                        <th>Category Name</th>
                        <th>Category Icon</th>
                        <th>Action</th>
                    </tr>
                    @foreach ($categories  as $sl=>$category)
                    <tr>
                        <td>
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input type="checkbox" name="category_id[]" value="{{$category->id}}" class="form-check-input chkDel">
                                <i class="input-frame"></i></label>
                            </div>
                        </td>
                        <td>{{$sl+1}}</td>
                        <td>{{$category->category_name}}</td>
                        <td><img src="{{asset('uploads/category')}}/{{$category->icon}}" alt="{{$category->icon}}"></td>
                        <td>
                            @can('category_edit')
                            <a href="{{route('category.edit', $category->id)}}" class="btn btn-primary btn-icon">
                                <i data-feather="edit"></i>
                            </a>
                            @endcan
                            @can('category_delete')
                            <a href="{{route('category.soft.delete', $category->id)}}" class="btn btn-danger btn-icon">
                                <i data-feather="trash"></i>
                            </a>
                            @endcan
                        </td>
                    </tr>
                    @endforeach
                </table>
                <div class="mt-2">
                    <button type="submit" class="btn btn-danger">Delete Checked</button>
                </div>
            </div>
        </div>
    </form>
</div>
@can('add_category')
<div class="col-lg-4">
    <div class="card">
        <div class="card-header">
            <h3>Add New Category</h3>
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">{{session('success')}}</div>
            @endif
            <form action="{{route('category.store')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Category Name</label>
                    <input type="text" name="category_name" class="form-control">
                    @error('category_name')
                        <strong class="text-danger">{{$message}}</strong>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Icon</label>
                    <input type="file" name="icon" class="form-control">
                    @error('icon')
                        <strong class="text-danger">{{$message}}</strong>
                    @enderror
                </div>
                <div class="mb-3">
                    <button type="submit" class="btn btn-primary">Add Category</button>
                </div>
            </form>
        </div>
      </div>
    </div>
</div>
@endcan
@endcan
@endsection

@section('footer_script')
<script>
    $("#chkSelectAll").on('click', function(){
        this.checked ? $(".chkDel").prop("checked",true) : $(".chkDel").prop("checked",false);
    })
</script>
@endsection
