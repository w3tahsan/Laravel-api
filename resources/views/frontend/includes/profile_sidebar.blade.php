<div class="col-lg-3">
    <div class="card text-center pt-2">
        @if (Auth::guard('customer')->user()->photo == null)
            <img width="70" class="m-auto" src="{{ Avatar::create(Auth::guard('customer')->user()->fname.' '. Auth::guard('customer')->user()->lname)->toBase64() }}" />
        @else
            <img width="70" class="m-auto" src="{{asset('uploads/customer')}}/{{Auth::guard('customer')->user()->photo}}"/>
        @endif
        <div class="card-body">
          <h5 class="card-title">{{Auth::guard('customer')->user()->fname.' '. Auth::guard('customer')->user()->lname}}</h5>
        </div>
        <ul class="list-group list-group-flush ">
          <li class="list-group-item py-3 bg-light"><a href="{{route('customer.profile')}}" class="text-dark">Profile</a></li>
          <li class="list-group-item py-3 bg-light"><a href="{{route('my.orders')}}" class="text-dark">My Order</a></li>
          <li class="list-group-item py-3 bg-light"><a href="" class="text-dark">My Wishlist</a></li>
          <li class="list-group-item py-3 bg-light"><a href="{{route('customer.logout')}}" class="text-dark">Logout</a></li>
        </ul>
      </div>
</div>
