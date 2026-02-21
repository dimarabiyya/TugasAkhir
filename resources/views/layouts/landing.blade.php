<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Learning Management System SMKN 40 - Transform your learning experience with our comprehensive educational platform designed for modern learners.">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>Learning Management System SMKN 40</title>
    
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('css/landing/bootstrap4/bootstrap.min.css') }}">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free-5.0.1/css/fontawesome-all.css') }}">
    
    <!-- Owl Carousel -->
    <link rel="stylesheet" href="{{ asset('plugins/OwlCarousel2-2.2.1/owl.carousel.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/OwlCarousel2-2.2.1/owl.theme.default.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/OwlCarousel2-2.2.1/animate.css') }}">
    
    <!-- Main Styles -->
    <link rel="stylesheet" href="{{ asset('css/landing/main_styles.css') }}">
    <link rel="stylesheet" href="{{ asset('css/landing/responsive.css') }}">
    <link rel="stylesheet" href="{{ asset('css/landing/colors-override.css') }}">

    <!-- plugins:css -->
    <link rel="stylesheet" href="{{ asset('skydash/vendors/feather/feather.css') }}">
    <link rel="stylesheet" href="{{ asset('skydash/vendors/ti-icons/css/themify-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('skydash/vendors/css/vendor.bundle.base.css') }}">
    <link rel="stylesheet" href="{{ asset('skydash/vendors/font-awesome/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('skydash/vendors/mdi/css/materialdesignicons.min.css') }}">
    
    <!-- inject:css -->
    <link rel="stylesheet" href="{{ asset('skydash/css/style.css') }}">
    
    <link href="images/landing/logo40.png" type="" rel="shortcut icon">
    @stack('styles')
    
    <style>
        body {
            font-family: 'Roboto', sans-serif;
        }
    </style>
</head>
<body>
    <div class="super_container">
        <!-- Header -->
        
        <header class="header d-flex flex-row">
            <div class="header_content d-flex flex-row align-items-center">
                <!-- Logo -->
                <div class="logo_container">
                    <div class="logo">
                        <img src="{{ asset('images/landing/logo40.png') }}" alt="SMKN 40 Jakarta" style="width: 70px; height: 70px;">
                        <span>SMKN 40 </span>
                    </div>
                </div>

                <!-- Main Navigation -->
                <nav class="main_nav_container">
                    <div class="main_nav">
                        <ul class="main_nav_list">
                            <li class="main_nav_item"><a href="{{ route('welcome') }}">Home</a></li>
                            <li class="main_nav_item"><a href="{{ route('landing.courses') }}">#</a></li>
                            <li class="main_nav_item"><a href="{{ route('landing.quizzes') }}">#</a></li>
                            <li class="main_nav_item"><a href="{{ route('landing.teachers') }}">#</a></li>
                        </ul>
                    </div>
                </nav>
            </div>
            
            <div class="header_side d-flex flex-row justify-content-center align-items-center">
                <a href="{{ route('login') }}" style="padding: 14px 30px; background: #0066CC; color: white; text-decoration: none; border-radius: 4px; font-weight: 700; ">
                    Login <i class="mdi mdi-arrow-right"></i></a>
            </div>
        </header>
        
        <!-- Main Content -->
        @yield('content')
        
        <!-- Footer -->
        <footer class="footer">
            <div class="container">
                
                <!-- Footer Content -->
                <div class="footer_content">
                    <div class="row">
                        <!-- About -->
                        <div class="col-lg-3 footer_col">
                            <div class="logo_container">
                                <div class="logo">
                                    <img src="{{ asset('images/landing/Logo40.png') }}" alt="Learning Management System SMKN 40 Logo">
                                    <span></span>
                                </div>
                            </div>
                            <p class="footer_about_text"></p>
                        </div>
                        
                        <!-- Menu -->
                        <div class="col-lg-3 footer_col">
                            <div class="footer_column_title">Menu</div>
                            <div class="footer_column_content">
                                <ul>
                                    <li class="footer_list_item"><a href="{{ route('welcome') }}#home">Home</a></li>
                                    <li class="footer_list_item"><a href="{{ route('landing.courses') }}">#</a></li>
                                    <li class="footer_list_item"><a href="{{ route('landing.quizzes') }}">#</a></li>
                                    <li class="footer_list_item"><a href="{{ route('landing.teachers') }}">#</a></li>
                                </ul>
                            </div>
                        </div>
                        
                        <!-- Useful Links -->
                        <div class="col-lg-3 footer_col">
                            <div class="footer_column_title">Useful Links</div>
                            <div class="footer_column_content">
                                <ul>
                                    <li class="footer_list_item"><a href="#">Testimonials</a></li>
                                    <li class="footer_list_item"><a href="#">Events</a></li>
                                    <li class="footer_list_item"><a href="#">FAQ</a></li>
                                    <li class="footer_list_item"><a href="#">Community</a></li>
                                    <li class="footer_list_item"><a href="#">Support</a></li>
                                </ul>
                            </div>
                        </div>
                        
                        <!-- Contact -->
                        <div class="col-lg-3 footer_col">
                            <div class="footer_column_title">Contact</div>
                            <div class="footer_column_content">
                                <ul>
                                    <li class="footer_contact_item">
                                        <div class="footer_contact_icon">
                                            <img src="{{ asset('images/landing/placeholder.svg') }}" alt="">
                                        </div>
                                        Jakarta, Indonesia
                                    </li>
                                    <li class="footer_contact_item">
                                        <div class="footer_contact_icon">
                                            <img src="{{ asset('images/landing/smartphone.svg') }}" alt="">
                                        </div>
                                        +62 234 5678 910
                                    </li>
                                    <li class="footer_contact_item">
                                        <div class="footer_contact_icon">
                                            <img src="{{ asset('images/landing/envelope.svg') }}" alt="">
                                        </div>
                                        smkn40jakarta@gmail.com
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <!-- Contact -->
                        <div class="col-lg-3 footer_col">
                            <div class="footer_column_title">Contact</div>
                            <div class="footer_column_content">
                                <ul>
                                    <li class="footer_contact_item">
                                        <div class="footer_contact_icon">
                                            <img src="{{ asset('images/landing/placeholder.svg') }}" alt="">
                                        </div>
                                        Jakarta, Indonesia
                                    </li>
                                    <li class="footer_contact_item">
                                        <div class="footer_contact_icon">
                                            <img src="{{ asset('images/landing/smartphone.svg') }}" alt="">
                                        </div>
                                        +62 234 5678 910
                                    </li>
                                    <li class="footer_contact_item">
                                        <div class="footer_contact_icon">
                                            <img src="{{ asset('images/landing/envelope.svg') }}" alt="">
                                        </div>
                                        smkn40jakarta@gmail.com
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Footer Bar -->
                <div class="footer_bar d-flex flex-column flex-sm-row align-items-center">
                    <div class="footer_copyright">
                        <span>© {{ date('Y') }} Learning Management System SMKN 40. All rights reserved.</span>
                    </div>
                    <div class="footer_social ml-sm-auto">
                        <ul class="menu_social">
                            <li class="menu_social_item"><a href="#"><i class="fab fa-pinterest"></i></a></li>
                            <li class="menu_social_item"><a href="#"><i class="fab fa-linkedin-in"></i></a></li>
                            <li class="menu_social_item"><a href="#"><i class="fab fa-instagram"></i></a></li>
                            <li class="menu_social_item"><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                            <li class="menu_social_item"><a href="#"><i class="fab fa-twitter"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </footer>
    </div>
    
    <!-- Scripts -->
    <script src="{{ asset('js/landing/jquery-3.2.1.min.js') }}"></script>
    <script src="{{ asset('css/landing/bootstrap4/popper.js') }}"></script>
    <script src="{{ asset('css/landing/bootstrap4/bootstrap.min.js') }}"></script>
    <script src="{{ asset('plugins/greensock/TweenMax.min.js') }}"></script>
    <script src="{{ asset('plugins/greensock/TimelineMax.min.js') }}"></script>
    <script src="{{ asset('plugins/scrollmagic/ScrollMagic.min.js') }}"></script>
    <script src="{{ asset('plugins/greensock/animation.gsap.min.js') }}"></script>
    <script src="{{ asset('plugins/greensock/ScrollToPlugin.min.js') }}"></script>
    <script src="{{ asset('plugins/easing/easing.js') }}"></script>
    <script src="{{ asset('plugins/parallax.js-2.0.0/jquery.parallax.min.js') }}"></script>
    <script src="{{ asset('plugins/progressbar/progressbar.min.js') }}"></script>
    <script src="{{ asset('plugins/scrollTo/jquery.scrollTo.min.js') }}"></script>
    <script src="{{ asset('plugins/OwlCarousel2-2.2.1/owl.carousel.js') }}"></script>
    <script src="{{ asset('js/landing/custom.js') }}"></script>
    
    @stack('scripts')
</body>
</html>

