@extends('layouts.admin')

@section('content')
<h3>Welcome to Dashboard, <strong class="text-primary">{{Auth::user()->name}}</strong></h3>
@endsection