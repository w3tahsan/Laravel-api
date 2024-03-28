<!DOCTYPE html>
<html lang="en">


<!-- Mirrored from wpocean.com/html/tf/themart/register.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 15 Jun 2023 08:56:41 GMT -->
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

        <div class="wpo-login-area">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <form class="wpo-accountWrapper" action="http://127.0.0.1:8000/api/customer/register" method="POST">
                            @csrf
                            <div class="wpo-accountInfo">
                                <div class="wpo-accountInfoHeader">
                                    <a href="index.html"><img src="{{asset('frontend')}}/images/logo-2.svg" alt=""></a>
                                    <a class="wpo-accountBtn" href="{{route('customer.login')}}">
                                        <span class="">Log in</span>
                                    </a>
                                </div>
                                <div class="image">
                                    <img src="{{asset('frontend')}}/images/login.svg" alt="">
                                </div>
                                <div class="back-home">
                                    <a class="wpo-accountBtn" href="{{route('index')}}">
                                        <span class="">Back To Home</span>
                                    </a>
                                </div>
                            </div>
                            <div class="wpo-accountForm form-style">
                                <div class="fromTitle">
                                    <h2>Signup</h2>
                                    <p>Sign into your pages account</p>
                                </div>
                                @if (session('success'))
                                    <div class="alert alert-success">{{session('success')}}</div>
                                @endif
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-12">
                                        <label for="name">First Name</label>
                                        <input type="text" id="name" name="fname" placeholder="Your name here..">
                                        @error('fname')
                                            <strong class="text-danger">{{$message}}</strong>
                                        @enderror
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-12">
                                        <label for="name">Last Name</label>
                                        <input type="text" id="name" name="lname" placeholder="Your name here..">
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-12">
                                        <label>Email</label>
                                        <input type="text" id="email" name="email" placeholder="Your email here..">
                                        @error('email')
                                            <strong class="text-danger">{{$message}}</strong>
                                        @enderror
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-12">
                                        <div class="form-group">
                                            <label>Password</label>
                                            <input class="pwd2" type="password" placeholder="Your password here.." name="password">
                                            <span class="input-group-btn">
                                                <button class="btn btn-default reveal3" type="button"><i class="ti-eye"></i></button>
                                            </span>
                                            @error('password')
                                                <strong class="text-danger">{{$message}}</strong>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-12">
                                        <div class="form-group">
                                            <label>Confirm Password</label>
                                            <input class="pwd3" type="password" placeholder="Your password here.." name="password_confirmation">
                                            <span class="input-group-btn">
                                                <button class="btn btn-default reveal2" type="button"><i class="ti-eye"></i></button>
                                            </span>
                                            @error('password_confirmation')
                                                <strong class="text-danger">{{$message}}</strong>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group mt-4 mb-4">
                                        <div class="captcha">
                                            <span>{!! captcha_img() !!}</span>
                                            <button type="button" class="btn btn-primary" class="reload" id="reload">
                                                refresh
                                            </button>
                                        </div>
                                    </div>
                                    <div class="form-group mb-4">
                                        <input id="captcha" type="text" class="form-control" placeholder="Enter Captcha" name="captcha">
                                    </div>
                                    @error('captcha')
                                        <strong class="text-danger">{{$message}}</strong>
                                    @enderror
                                    <div class="col-lg-12 col-md-12 col-12">
                                        <button type="submit" class="wpo-accountBtn">Signup</button>
                                    </div>
                                </div>

                                <p class="subText">Sign into your pages account <a href="{{route('customer.login')}}">Login</a></p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>


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
    <script type="text/javascript">
        $('#reload').click(function () {
            $.ajax({
                type: 'GET',
                url: '/reload-captcha',
                success: function (data) {
                    $(".captcha span").html(data.captcha);
                }
            });
        });
    </script>
</body>


<!-- Mirrored from wpocean.com/html/tf/themart/register.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 15 Jun 2023 08:56:41 GMT -->
</html>
