@extends('layouts.admin')
@section('content')
    <div class="row">
        <div class="col-lg-6 m-auto">
            <div class="card">
                <div class="card-header">
                    <h3>Send SMS</h3>
                </div>
                <div class="card-header">
                    @if (session('send'))
                        <div class="alert alett-success">{{ session('send') }}</div>
                    @endif
                    <form action="{{ route('sms.send') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="" class="form-label">Enter Number</label>
                            <input type="text" name="number" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Enter Message</label>
                            <textarea name="message" class="form-control" cols="30" rows="6"></textarea>
                        </div>
                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary">Send</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
