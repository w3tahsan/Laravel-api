@extends('layouts.admin')
@section('content')
<div class="row">
    <div class="col-lg-8 m-auto">
        <div class="card">
            <div class="card-header">
                <h3>Edit Role</h3>
            </div>
            <div class="card-body">
                <form action="{{route('update.role', $role->id)}}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="" class="form-label">Role Name</label>
                        <input type="text" name="role_name" class="form-control" value="{{$role->name}}">
                    </div>
                    <div class="mb-3">
                        @foreach ($permissions as $permission)
                        <div class="form-check form-check-inline">
                            <input {{$role->hasPermissionTo($permission->name)?'checked':''}} type="checkbox" name="permission[]" class="form-check-input" id="per{{$permission->id}}" value="{{$permission->name}}">
                            <label class="form-check-label ml-0" for="per{{$permission->id}}">
                                {{$permission->name}}
                            </label>
                        </div>
                        @endforeach
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary">Update Role</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
