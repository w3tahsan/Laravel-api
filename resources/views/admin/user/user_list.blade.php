@extends('layouts.admin')
@section('content')
@can('user_access')
<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h3>User List</h3>
            </div>
            <div class="card-body">
                @if (session('delete'))
                    <div class="alert alert-success">{{session('delete')}}</div>
                @endif
                <table class="table table-bordered">
                    <tr>
                        <th>SL</th>
                        <th>Photo</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Action</th>
                    </tr>
                    @foreach ($users as $sl=>$user)
                    <tr>
                        <td>{{$sl+1}}</td>
                        <td>
                            @if ($user->photo == null)
                            <img src="{{ Avatar::create($user->name)->toBase64() }}" />
                            @else
                            <img width="" src="{{asset('uploads/user')}}/{{$user->photo}}"/>
                            @endif
                        </td>
                        <td>{{$user->name}}</td>
                        <td>{{$user->email}}</td>
                        <td>
                            @can('user_delete')
                            <a href="{{route('user.delete', $user->id)}}" class="btn btn-danger btn-icon">
                                <i data-feather="trash"></i>
                            </a>
                            @endcan
                        </td>
                    </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
    @can('user_add')
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h3>Add New User</h3>
            </div>
            <div class="card-body">
                @if (session('success'))
                    <div class="alert alert-success">{{session('success')}}</div>
                @endif
                <form action="{{route('user.add')}}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" name="name" class="form-control" value="{{old('name')}}">
                        @error('name')
                            <strong class="text-danger">{{$message}}</strong>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" value="{{old('email')}}">
                        @error('email')
                            <strong class="text-danger">{{$message}}</strong>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" value="{{old('password')}}">
                        @error('password')
                            <strong class="text-danger">{{$message}}</strong>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Confirm Password</label>
                        <input type="password" name="confirm_password" class="form-control" value="{{old('confirm_password')}}">
                        @error('confirm_password')
                            <strong class="text-danger">{{$message}}</strong>
                        @enderror
                        @if (session('match'))
                            <strong class="text-danger">{{session('match')}}</strong>
                        @endif
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary">Add User</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endcan
</div>
@else
<h3 class="text-warning">You dont have to access this page</h3>
@endcan
@endsection
