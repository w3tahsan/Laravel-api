@extends('layouts.admin')
@section('content')
@can('subcategory_access')
<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h3>Subcategory List</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    @foreach ($categories as $category)
                    <div class="col-lg-6 my-2">
                        <div class="card">
                            <div class="card-header">
                                <h4>{{$category->category_name}}</h4>
                            </div>
                            <div class="card-body">
                                <table class="table table-bordered">
                                    <tr>
                                        <th>Sub Category</th>
                                        <th>Action</th>
                                    </tr>
                                    @forelse (App\Models\Subcategory::where('category_id', $category->id)->get() as $subcategory)
                                    <tr>
                                        <td>{{$subcategory->sub_category}}</td>
                                        <td>
                                            @can('subcategory_edit')
                                            <a href="{{route('sub.category.edit', $subcategory->id)}}" class="btn btn-primary btn-icon">
                                                <i data-feather="edit"></i>
                                            </a>
                                            @endcan
                                            @can('subcategory_delete')
                                            <a class="btn btn-danger btn-icon del_btn" data-link="{{route('sub.category.delete', $subcategory->id)}}">
                                                <i data-feather="trash"></i>
                                            </a>
                                            @endcan
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="2" class="text-center">No Subcategory Found</td>
                                    </tr>
                                    @endforelse

                                </table>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    @can('subcategory_add')
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h3>Add New Sub Category</h3>
            </div>
            <div class="card-body">
                @if (session('exist'))
                    <div class="alert alert-warning">{{session('exist')}}</div>
                @endif
                <form action="{{route('sub.category.store')}}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <select name="category" class="form-control">
                            <option value="">Select Category</option>
                            @foreach ($categories as $category)
                                <option value="{{$category->id}}">{{$category->category_name}}</option>
                            @endforeach
                        </select>
                        @error('category')
                            <strong class="text-danger">{{$message}}</strong>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Subcategory Name</label>
                        <input type="text" name="sub_category" class="form-control">
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
    @endcan
</div>
@endcan
@endsection
@section('footer_script')
<script>
    $('.del_btn').click(function(){
        var link = $(this).attr('data-link');
        Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = link;
        }
        })
    })
</script>

@if (session('success'))
    <script>
        Swal.fire(
        'Deleted!',
        '{{session('success')}}',
        'success'
        )
    </script>
@endif

@endsection
