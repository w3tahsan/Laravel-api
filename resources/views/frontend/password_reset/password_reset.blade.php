<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="wpOceans">
    <link rel="shortcut icon" type="image/png" href="{{asset('frontend')}}/images/favicon.png">
    <title>Themart - eCommerce HTML5 Template</title>
    <link href="{{asset('frontend')}}/css/themify-icons.css" rel="stylesheet">
    <link href="{{asset('frontend')}}/css/font-awesome.min.css" rel="stylesheet">
    <link href="{{asset('frontend')}}/css/flaticon_ecommerce.css" rel="stylesheet">
    <link href="{{asset('frontend')}}/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{asset('frontend')}}/css/animate.css" rel="stylesheet">
    <link href="{{asset('frontend')}}/css/owl.carousel.css" rel="stylesheet">
    <link href="{{asset('frontend')}}/css/owl.theme.css" rel="stylesheet">
    <link href="{{asset('frontend')}}/css/slick.css" rel="stylesheet">
    <link href="{{asset('frontend')}}/css/slick-theme.css" rel="stylesheet">
    <link href="{{asset('frontend')}}/css/swiper.min.css" rel="stylesheet">
    <link href="{{asset('frontend')}}/css/owl.transitions.css" rel="stylesheet">
    <link href="{{asset('frontend')}}/css/jquery.fancybox.css" rel="stylesheet">
    <link href="{{asset('frontend')}}/css/odometer-theme-default.css" rel="stylesheet">
    <link href="{{asset('frontend')}}/sass/style.css" rel="stylesheet">
</head>

<body>

    <!-- start page-wrapper -->
    <div class="page-wrapper">
        <!-- start preloader -->
        <div class="preloader">
            <div class="vertical-centered-box">
                <div class="content">
                    <div class="loader-circle"></div>
                    <div class="loader-line-mask">
                        <div class="loader-line"></div>
                    </div>
                    <img src="{{asset('frontend')}}/images/preloader.png" alt="">
                </div>
            </div>
        </div>
        <!-- end preloader -->

             <!-- login-area start -->
             <div class="tp-login-area">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <form class="tp-accountWrapper" action="{{route('pass.reset.req')}}" method="POST">
                                @csrf
                                <div class="tp-accountInfo">
                                    <div class="tp-accountInfoHeader">
                                        <a href="index.html"><img src="{{asset('frontend')}}/images/logo-2.svg" alt=""> </a>
                                        <a class="tp-accountBtn" href="{{route('customer.register')}}">
                                            <span class="">Create Account</span>
                                        </a>
                                    </div>
                                    <div class="image">
                                        <img src="{{asset('frontend')}}/images/login.svg" alt="">
                                    </div>
                                    <div class="back-home">
                                        <a class="tp-accountBtn" href="{{route('index')}}">
                                            <span class="">Back To Home</span>
                                        </a>
                                    </div>
                                </div>
                                <div class="tp-accountForm form-style">
                                    <div class="fromTitle">
                                        <h2>Reset Password</h2>
                                        <p>Sign into your pages account</p>

                                        <div class="py-2">
                                            @if (session('sent'))
                                                <div class="alert alert-success">{{session('sent')}}</div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-12">
                                            <label>Email</label>
                                            <input type="text" id="email" name="email" placeholder="demo@gmail.com">
                                            @error('email')
                                                <strong class="text-danger">{{$message}}</strong>
                                            @enderror
                                            @if (session('exist'))
                                                <strong class="text-danger">{{session('exist')}}</strong>
                                            @endif
                                        </div>
                                        <div class="col-lg-12 col-md-12 col-12">
                                            <button type="submit" class="tp-accountBtn">Resend Password</button>
                                        </div>
                                    </div>

                                    <p class="subText">Don't have an account? <a href="{{route('customer.register')}}">Create free
                                            account</a></p>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- login-area end -->


    </div>
    <!-- end of page-wrapper -->

    <!-- All JavaScript files
    ================================================== -->
    <script src="{{asset('frontend')}}/js/jquery.min.js"></script>
    <script src="{{asset('frontend')}}/js/bootstrap.bundle.min.js"></script>
    <!-- Plugins for this template -->
    <script src="{{asset('frontend')}}/js/modernizr.custom.js"></script>
    <script src="{{asset('frontend')}}/js/jquery.dlmenu.js"></script>
    <script src="{{asset('frontend')}}/js/jquery-plugin-collection.js"></script>
    <!-- Custom script for this template -->
    <script src="{{asset('frontend')}}/js/script.js"></script>
</body>


<!-- Mirrored from wpocean.com/html/tf/themart/forgot.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 15 Jun 2023 08:56:45 GMT -->
</html>
