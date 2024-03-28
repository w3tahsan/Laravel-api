@extends('layouts.admin')
@section('content')
@can('coupon_access')
<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h3>Coupon List</h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th>SL</th>
                        <th>Coupon</th>
                        <th>Type</th>
                        <th>Amount</th>
                        <th>Validity</th>
                        <th>Limit</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                    @foreach ($coupons as $sl=>$coupon)
                    <tr>
                        <td>{{ $sl+1 }}</td>
                        <td>{{ $coupon->coupon }}</td>
                        <td>{{ $coupon->type==1?'Percentage':'Solid' }}</td>
                        <td>{{ $coupon->amount }}</td>
                        <td>{{ $coupon->validity }}</td>
                        <td>{{ $coupon->limit }}</td>
                        <td>
                            @can('coupon_status')

                            <a href="{{ route('coupon.status', $coupon->id) }}" class="btn btn-{{ $coupon->status == 1?'success':'secondary' }}">{{ $coupon->status == 1?'Active':'Deactive' }}</a>
                            @endcan
                        </td>
                        <td>
                            @can('coupon_delete')
                            <a href="" class="btn btn-danger">Delete</a>
                            @endcan
                        </td>
                    </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
    @can('coupon_add')

    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h3>Add New Coupon</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('coupon.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="" class="form-label">Coupon</label>
                        <input type="text" name="coupon" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Type</label>
                        <select name="type" class="form-control">
                            <option value="">Select Type</option>
                            <option value="1">Percentage</option>
                            <option value="2">Solid</option>
                        </select>
                        @error('type')
                            <div class="alert alert-danger">{{$message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Amount</label>
                        <input type="number" name="amount" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Validity</label>
                        <input type="date" name="validity" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Limit</label>
                        <input type="number" name="limit" class="form-control">
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary">Add Coupon</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endcan
</div>
@endcan
@endsection
