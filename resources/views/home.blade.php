@extends('layouts.app')
<head>
    {{--<meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="apple-touch-icon" href="apple-touch-icon.png">

    <link rel="stylesheet" href="{{asset('app-assets/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('app-assets/css/bootstrap-theme.min.css')}}">
    <link rel="stylesheet" href="{{asset('app-assets/css/fontAwesome.css')}}">
    <link rel="stylesheet" href="{{asset('app-assets/css/hero-slider.css')}}">--}}
    <link rel="stylesheet" href="{{asset('app-assets/css/owl-carousel.css')}}">
    <link rel="stylesheet" href="{{asset('app-assets/css/datepicker.css')}}">
    <link rel="stylesheet" href="{{asset('app-assets/css/tooplate-style.css')}}">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800">

    <script type="text/javascript" src="{{asset('app-assets/js/vendor/modernizr-2.8.3-respond-1.4.2.min.js')}}"></script>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

    <!-- Styles -->
    <style>
        html, body {
            background-color: #fff;
            color: #636b6f;
            font-family: 'Nunito', sans-serif;
            font-weight: 200;
            height: 100vh;
            margin: 0;
        }

        .full-height {
            height: 100vh;
        }

        .flex-center {
            align-items: center;
            display: flex;
            justify-content: center;
        }

        .position-ref {
            position: relative;
        }

        .top-right {
            position: absolute;
            right: 10px;
            top: 18px;
        }

        .content {
            text-align: center;
        }

        .title {
            font-size: 84px;
        }

        .links > a {
            color: #ffd700;
            padding: 0 25px;
            font-size: 16px;
            font-weight: 1000;
            letter-spacing: .1rem;
            text-decoration: none;
            text-transform: uppercase;
        }

        .m-b-md {
            margin-bottom: 30px;
        }

        #form_princ{
            margin-top: -80px;
        }
    </style>
</head>
@section('content')
    <section class="banner" id="top">
        <div class="container">
            <div class="row">
                @if (Route::has('login'))
                    <div class="top-right links">
                        @auth
                        <a href="{{ url('/home') }}"></a>
                        <br>
                        {{--<a href="">Cancel Flight</a>--}}
                        @else
                            <a href="{{ route('login') }}">Login</a>
                            <br>
                            <br>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}">Register</a>
                            @endif
                            @endauth
                    </div>
                @endif
                <div class="col-md-5">
                    <div class="left-side">
                        <div class="logo">
                            <img src="{{asset('app-assets/img/logo.png')}}" alt="Flight Template">
                        </div>
                        <div class="tabs-content">
                            <h4>Choose Your Direction:</h4>
                            <ul class="social-links">
                                <li><a href="http://facebook.com">Find us on <em>Facebook</em><i class="fa fa-facebook"></i></a></li>
                                <li><a href="http://youtube.com">Our <em>YouTube</em> Channel<i class="fa fa-youtube"></i></a></li>
                                <li><a href="http://instagram.com">Follow our <em>instagram</em><i class="fa fa-instagram"></i></a></li>
                            </ul>
                        </div>
                        <div class="page-direction-button">
                            <a href="contact.html"><i class="fa fa-phone"></i>Contact Us Now</a>
                        </div>
                    </div>
                </div>
                <div id="form_princ" class="col-md-5 col-md-offset-1">
                    <section id="first-tab-group" class="tabgroup">
                        <div id="tab1">
                            <div class="submit-form">
                                <h4>Check availability for <em>direction</em>:</h4>
                                @if(session()->has('message'))
                                    <div class="alert alert-success">
                                        {{ session()->get('message') }}
                                    </div>
                                @endif
                                @if(session()->has('message_echec'))
                                    <div class="alert alert-danger">
                                        {{ session()->get('message_echec') }}
                                    </div>
                                @endif
                                <form id="form-submit" action="{{route('home')}}" method="post">
                                    {{ csrf_field() }}
                                    <div class="row">
                                        <div class="col-md-6">
                                            <fieldset>
                                                <label for="ville_from">From:</label>
                                                <select name="ville_from" id="ville_from" onchange='this.form.()' required autofocus >
                                                    <option value="">Select a location...</option>
                                                    @foreach ($villes as $key => $value)
                                                        <option value={{ $key }} @if(old('ville_from') == $key) {{'selected'}} @endif>{{ $value }}</option>
                                                    @endforeach
                                                </select>
                                            </fieldset>
                                        </div>
                                        <div class="col-md-6">
                                            <fieldset>
                                                <label for="ville_to">To:</label>
                                                <select name="ville_to" id="ville_to" onchange='this.form.()' required autofocus >
                                                    <option value="">Select a location...</option>
                                                    @foreach ($villes as $key => $value)
                                                        <option value={{ $key }} @if(old('ville_to') == $key) {{'selected'}} @endif>{{ $value }}</option>
                                                    @endforeach
                                                </select>
                                            </fieldset>
                                        </div>
                                        <div class="col-md-6">
                                            <fieldset>
                                                <label for="departure">Departure date:</label>
                                                <input name="departure" type="text" class="form-control date" id="departure" placeholder="Select date..." required="" onchange='this.form.()'>
                                            </fieldset>
                                        </div>
                                        <div class="col-md-6">
                                            <fieldset>
                                                <label for="return">Return date:</label>
                                                <input name="return" type="text" class="form-control date" id="return" placeholder="Select date..." onchange='this.form.()'>
                                            </fieldset>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="radio-select">
                                                <div class="row">
                                                    <div class="col-md-6 col-sm-6 col-xs-6">
                                                        <label for="round">Round</label>
                                                        <input type="radio" name="trip" id="round" value="round" required="required"onchange='this.form.()'>
                                                    </div>
                                                    <div class="col-md-6 col-sm-6 col-xs-6">
                                                        <label for="oneway">Oneway</label>
                                                        <input type="radio" name="trip" id="oneway" value="one_way" required="required"onchange='this.form.()'>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <fieldset>
                                                <button type="submit" id="form-submit" class="btn">Order Ticket Now</button>
                                            </fieldset>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </section>

{{--<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="left-side">
                <div class="logo">
                    <img src="{{asset('app-assets/img/logo.png')}}" alt="Flight Template">
                </div>
                <div class="tabs-content">
                    <h4>Choose Your Direction:</h4>
                    <ul class="social-links">
                        <li><a href="http://facebook.com">Find us on <em>Facebook</em><i class="fa fa-facebook"></i></a></li>
                        <li><a href="http://youtube.com">Our <em>YouTube</em> Channel<i class="fa fa-youtube"></i></a></li>
                        <li><a href="http://instagram.com">Follow our <em>instagram</em><i class="fa fa-instagram"></i></a></li>
                    </ul>
                </div>
                <div class="page-direction-button">
                    <a href="contact.html"><i class="fa fa-phone"></i>Contact Us Now</a>
                </div>
            </div>
        </div>
    </div>
</div>--}}
@endsection
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script>window.jQuery || document.write('<script src="{{asset('app-assets/js/vendor/jquery-1.11.2.min.js')}}"><\/script>')</script>

<script src="{{asset('app-assets/js/vendor/bootstrap.min.js')}}"></script>

<script src="{{asset('app-assets/js/datepicker.js')}}"></script>
<script src="{{asset('app-assets/js/plugins.js')}}"></script>
<script src="{{asset('app-assets/js/main.js')}}"></script>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js" type="text/javascript"></script>
<script type="text/javascript">
    $(document).ready(function() {

        // navigation click actions
        $('.scroll-link').on('click', function(event){
            event.preventDefault();
            var sectionID = $(this).attr("data-id");
            scrollToID('#' + sectionID, 750);
        });
        // scroll to top action
        $('.scroll-top').on('click', function(event) {
            event.preventDefault();
            $('html, body').animate({scrollTop:0}, 'slow');
        });
        // mobile nav toggle
        $('#nav-toggle').on('click', function (event) {
            event.preventDefault();
            $('#main-nav').toggleClass("open");
        });
    });
    // scroll function
    function scrollToID(id, speed){
        var offSet = 0;
        var targetOffset = $(id).offset().top - offSet;
        var mainNav = $('#main-nav');
        $('html,body').animate({scrollTop:targetOffset}, speed);
        if (mainNav.hasClass("open")) {
            mainNav.css("height", "1px").removeClass("in").addClass("collapse");
            mainNav.removeClass("open");
        }
    }
    if (typeof console === "undefined") {
        console = {
            log: function() { }
        };
    }
</script>
