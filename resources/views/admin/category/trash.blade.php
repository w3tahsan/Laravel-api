@extends('layouts.admin')
@section('content')
<div class="row">
    <div class="col-lg-8">
        <form action="{{route('checked.restore')}}" method="POST">
            @csrf
            <div class="card">
                <div class="card-header">
                    <h3>Category List</h3>
                </div>
                <div class="card-body">
                    @if (session('restore'))
                        <div class="alert alert-success">{{session('restore')}}</div>
                    @endif
                    @if (session('pdelete'))
                        <div class="alert alert-success">{{session('pdelete')}}</div>
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
                        @forelse ($categories  as $sl=>$category)
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
                                <a title="Restore" href="{{route('category.restore', $category->id)}}" class="btn btn-success btn-icon">
                                    <i data-feather="rotate-cw"></i>
                                </a>
                                <a title="Permanent Delete" href="{{route('category.permanent.delete', $category->id)}}" class="btn btn-danger btn-icon">
                                    <i data-feather="trash"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4"><h4 class="text-center text-info">No Trash Category Found</h4></td>
                        </tr>
                        @endforelse
                    </table>
                    <div class="mt-2">
                        <button type="submit" class="btn btn-success">Restore Checked</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>    
@endsection
@section('footer_script')
<script>
    $("#chkSelectAll").on('click', function(){
        this.checked ? $(".chkDel").prop("checked",true) : $(".chkDel").prop("checked",false);  
    })
</script>
@endsection