<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
<!-- Chrome, Firefox OS and Opera -->
<meta name="theme-color" content="#3E2723">
<!-- Windows Phone -->
<meta name="msapplication-navbutton-color" content="#3E2723">
<!-- iOS Safari -->
<meta name="apple-mobile-web-app-status-bar-style" content="#3E2723">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} | @yield('title')</title>

    <!-- Styles --> 
    <link rel="stylesheet" type="text/css" href="{{secure_asset('css/bootstrap.css')}}">
	<link rel="stylesheet" type="text/css" href="{{secure_asset('css/kopigenik.css')}}">
    <link rel="stylesheet" type="text/css" href="{{secure_asset('css/awesomplete.css')}}">
    <link rel="stylesheet" type="text/css" href="{{secure_asset('css/custom.css')}}">
	<link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet" type="text/css">
	<link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs/dt-1.10.16/fh-3.1.3/r-2.2.0/datatables.min.css">


    <!--jquery script-->
    <script src="{{secure_asset('js/app.js')}}"></script>    
    <script src="{{secure_asset('js/awesomplete.min.js')}}"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs/dt-1.10.16/fh-3.1.3/r-2.2.0/datatables.min.js"></script>


</head>
<body>
    <div id="app">
        <!-- Navbar -->
        <nav class="navbar navbar-default navbar-fixed-top">
            <div class="container-fluid container-navbar">
                <div class="navbar-header">
                    <button class="navbar-toggle" type="button" data-toggle="collapse" data-target="#myNavbar">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                    <a class="navbar-brand" href="{{ secure_url('/') }}"><img class="img-responsive" src="{{secure_asset('asset/kopigenikbanner.png')}}"></a>

                </div>
                <div class="collapse navbar-collapse navbarKu" id="myNavbar">
                    <ul class="nav navbar-nav navbar-right">
                        <li class="navBurger"><a class="navbarKu" href="\subscribe">BERLANGGANAN</a></li>
                        <li class="navBurger"><a class="navbarKu" href="\beans">BELANJA</a></li>
                        <li class="navBurger"><a class="navbarKu" href="\videos">VIDEO</a></li>
                        <li class="navBurger"><a class="navbarKu" href="\about-us">TENTANG KAMI</a></li>
                        <li class="navBurger"><a class="navbarKu" href="\faq">FAQ</a></li>
                        <li class="navBurger"><a class="navbarKu" href="\wordpress">BLOG</a></li>
                        <li class="dropdown">
                            @guest
                                    <li class="navBurger"><a class="navbarKu" href="{{ route('login') }}">MASUK</a></li>
                                    <li class="navBurger"><a class="navbarKu" href="{{ route('register') }}">DAFTAR</a></li>     
                            @else
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button">{{auth()->user()->name}} <span class="caret"></span></a>
                                
                                <ul class="dropdown-menu">

                                    @role('admin')
                                        <li class="navBurger"><a class="navbarKu" href="\transactions">TRANSAKSI</a></li>
                                        <li class="navBurger"><a class="navbarKu" href="\shipments">PENGIRIMAN</a></li>
                                        <li class="navBurger"><a class="navbarKu" href="\blog-admin">BLOG</a></li>
                                    @else                                     
                                        <li class="navBurger"><a class="navbarKu" href="\check-shipments">RIWAYAT BERLANGGANAN</a></li>
                                    @endrole
                                    <li class="navBurger"><a class="navbarKu" href="\profile">UBAH PROFIL</a></li>

                                    <li class="navBurger">
                                        <a class="navbarKu" href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                    document.getElementById('logout-form').submit();">
                                            KELUAR
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                            @endguest
                        </li>
                        
                    </ul>
                </div>
            </div>
        </nav>
        

        <!-- Content -->
        @yield('content')

        @include('layouts.errors')

        <!--Footer-->
        <footer class="footer-btm container-fluid container-inner bg-black1">
            <div class="row">
                <div class="col-sm-4">
                    <h5 style="color: #f7db9c;">QUICK LINKS</h5>
                    <ul>
                        <li><a href="\subscribe">Berlangganan</a></li>
                        <li><a href="\beans">Belanja</a></li>
                        <li><a href="\login">Masuk</a></li>
                    </ul>
                </div>
                <div class="col-sm-4">
                    <h5 style="color: #f7db9c;">TENTANG KAMI</h5>
                    <ul>
                        <li><a href="\about-us">Apa itu Kopigenik</a></li>
                        <li><a href="\faq">FAQ</a></li>
                        <li><a href="\wordpress">Blog</a></li>
                        <li><a href="\contact-us">Hubungi Kami</a></li>
                    </ul>
                </div>
                <div class="col-sm-4">
                    <h5 style="color: #f7db9c;">SOCIAL MEDIA</h5>
                    <ul>
                        <li>
                            <a href="https://facebook.com/kopigenik" target="__blank">
                                <img class="icon-social-media" src="{{secure_asset('asset/icon-facebook.svg')}}">
                                <span>Kopigenik</span>
                            </a>
                        </li>
                        <li>
                            <a href="https://instagram.com/kopigenik" target="__blank">
                                <img class="icon-social-media" src="{{secure_asset('asset/icon-instagram.svg')}}">
                                <span>@kopigenik</span>
                            </a>
                        </li>
                        <li>                        
                            <img class="icon-social-media" src="{{secure_asset('asset/icon-line.jpg')}}">
                            <span style="color: #fff;">@kopigenik</span>                            
                        </li>
                        <li style="margin-left: 50px;">
                            <div class="line-it-button" data-lang="en" data-type="friend" data-lineid="@kopigenik" data-count="true" data-home="true" style="display: none; padding-top: 5px;"></div>                            
                        </li>
                    </ul>
                </div>
            </div>
        </footer>


    </div>

    <!-- Scripts -->
	<!-- <script src="{{asset('js/bootstrap.js')}}"></script> -->
	<script src="{{secure_asset('js/kopigenik.js')}}"></script>
	<script src="{{secure_asset('js/velocity.js')}}"></script>
    
    <script src="https://d.line-scdn.net/r/web/social-plugin/js/thirdparty/loader.min.js" async="async" defer="defer"></script>
    <script type="text/javascript">

        NProgress.configure({ minimum: 0.3, easing: 'linear', showSpinner:false, trickleSpeed: 100 }); 

        //loading page
        document.onreadystatechange = function(e)
        {
            if (document.readyState != 'complete')
            {
                NProgress.start();
            }else if(document.readyState == 'complete'){
                NProgress.done();
            }
        };
        // window.onload = function(e)
        // {
        //     //document.readyState will be complete, it's one of the requirements for the window.onload event to be fired
        //     //do stuff for when everything is loaded
        // };

        $(document).ajaxStart(function(){
            NProgress.start();
        });

        $(document).ajaxStop(function(){
            NProgress.done();
        });


        $(document).ready(function(){
            $('.dropdown-toggle').dropdown();

            //set active class to clicked li
            $pathnameLocal = (location.pathname).substr(18);//18 karena potong tulisan /kopigenik-master/
            $pathnameHosting = (location.pathname).substr(1);//1 karena potong /
            $(".nav li").each(function(){       
                if($(this).children().attr("href") == $pathnameLocal){
                    $(this).addClass("active");
                }
            });


            //disable button after submit
            $("form").submit(function(){
                $(this).find("button[type='submit']").attr('disabled','disabled');
            });

        });
            
    </script>

</body>
</html>
