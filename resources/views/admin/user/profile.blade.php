@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col-lg-4">
        <div class="card">
            <div class="card-body">
                <h6 class="card-title">Update Profile Info</h6>
                @if (session('info_update'))
                    <div class="alert alert-success">{{session('info_update')}}</div>
                @endif
                <form class="forms-sample" action="{{route('user.info.update')}}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="exampleInputUsername1">Name</label>
                        <input type="text" class="form-control" name="name" value="{{Auth::user()->name}}"> 
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Email</label>
                        <input type="email" class="form-control" name="email" value="{{Auth::user()->email}}">
                    </div>
                    <button type="submit" class="btn btn-primary mr-2">Update</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card">
            <div class="card-body">
                <h6 class="card-title">Password Update</h6>
                @if(session('password'))
                    <div class="alert alert-success">{{session('password')}}</div>
                @endif
                <form class="forms-sample" action="{{route('password.update')}}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="exampleInputUsername1">Current Password</label>
                        <input type="password" class="form-control" name="current_password" > 
                        @error('current_password')
                            <strong class="text-danger">{{$message}}</strong>
                        @enderror
                        @if(session('wrong'))
                            <strong class="text-danger">{{session('wrong')}}</strong>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="exampleInputUsername1">New Password</label>
                        <input type="password" class="form-control" name="password" > 
                        @error('password')
                            <strong class="text-danger">{{$message}}</strong>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="exampleInputUsername1">Confirm Password</label>
                        <input type="password" class="form-control" name="password_confirmation" >
                        @error('password_confirmation')
                            <strong class="text-danger">{{$message}}</strong>
                        @enderror 
                    </div>
                    
                    <button type="submit" class="btn btn-primary mr-2">Update</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card">
            <div class="card-body">
                <h6 class="card-title">Profile Photo Update</h6>
                @if(session('photo_update'))
                    <div class="alert alert-success">{{session('photo_update')}}</div>
                @endif
                <form class="forms-sample" action="{{route('photo.update')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="exampleInputUsername1">Upload Photo</label>
                        <input type="file" class="form-control" name="photo" > 
                        @error('photo')
                            <strong class="text-danger">{{$message}}</strong>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary mr-2">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection