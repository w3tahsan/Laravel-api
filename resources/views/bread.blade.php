 <!-- start wpo-page-title -->
 <section class="wpo-page-title">
    <h2 class="d-none">Hide</h2>
    <div class="container">
        <div class="row">
            <div class="col col-xs-12">
                <div class="wpo-breadcumb-wrap">
                    <ol class="wpo-breadcumb-wrap">
                        <li class="breadcrumb-item">
                            <a href="{{ route('index') }}">Home</a>
                        </li>
                        @foreach (Request::segments() as $segment)
                            <li class="breadcrumb-item active" aria-current="page">
                                {{ ucwords($segment) }}
                            </li>
                        @endforeach
                    </ol>
                </div>
            </div>
        </div> <!-- end row -->
    </div> <!-- end container -->
</section>
<!-- end page-title -->
