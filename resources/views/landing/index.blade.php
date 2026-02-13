@extends('layouts.landing')

@section('content')
<!-- Home Section -->
<div class="home" id="home">
    @push('styles')
    <style>
        /* Enhanced Milestones Styling */
        .milestones {
            width: 100%;
            background: linear-gradient(135deg, #2C3E50 0%, #1a1a1a 100%);
            position: relative;
            padding-top: 100px;
            padding-bottom: 100px;
        }
        .milestones_background {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-repeat: no-repeat;
            background-size: cover;
            background-position: center center;
            opacity: 0.15;
        }
        .milestone_col {
            padding-top: 40px;
            padding-bottom: 40px;
            text-align: center;
        }
        .milestone {
            position: relative;
            background: rgba(255, 255, 255, 0.05);
            padding: 30px 20px;
            border-radius: 8px;
            transition: all 0.3s ease;
            border-left: 4px solid #FFD700;
        }
        .milestone:hover {
            background: rgba(220, 20, 60, 0.1);
            transform: translateY(-5px);
        }
        .milestone_icon {
            margin-bottom: 20px;
            display: flex;
            justify-content: center;
        }
        .milestone_icon img {
            width: 60px;
            height: auto;
            filter: brightness(0) invert(1);
        }
        .milestone_counter {
            font-size: 36px;
            font-weight: 700;
            color: #FFD700;
            line-height: 1;
            margin-bottom: 10px;
        }
        .milestone_text {
            font-size: 14px;
            font-weight: 500;
            color: #FFFFFF;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        /* Enhanced testimonials styling */
        .testimonials_background {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-repeat: no-repeat;
            background-size: cover;
            background-position: center center;
            opacity: 0.15;
        }
        .testimonials_background_container {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
        }
        .testimonials {
            position: relative;
            width: 100%;
            background: linear-gradient(135deg, #2C3E50 0%, #1a1a1a 100%);
            padding-top: 100px;
            padding-bottom: 100px;
        }
        .testimonials .container {
            position: relative;
            z-index: 1;
        }
        .testimonials .section_title h1 {
            color: #FFFFFF !important;
        }
        
        .section_title h1 {
            color: #DC143C;
            font-size: 2.5rem;
            margin-bottom: 2rem;
            font-weight: 600;
        }
        /* Hero boxes styling - text white with red accent */
        .hero_box_title {
            color: #FFFFFF !important;
            font-weight: 600;
        }
        .hero_box_link {
            color: #FFD700 !important;
            opacity: 0.9;
            font-weight: 600;
        }
        }
        .hero_box_link:hover {
            color: #FFB606 !important;
            opacity: 1;
            text-decoration: underline;
        }
        .card-title a {
            color: #DC143C;
            font-weight: 600;
            text-decoration: none;
        }
        .card-title a:hover {
            color: #0066CC;
        }
        .register_title span {
            color: #FFD700;
            font-weight: 700;
        }
        
        /* Button Styling - Updated Colors */
        .button
        {
            height: 48px;
            padding-left: 38px;
            padding-right: 38px;
            background: #0066CC;
            border-radius: 6px;
            text-align: center;
            cursor: pointer;
            box-shadow: 0 2px 8px rgba(0, 102, 204, 0.2);
            transition: all 0.3s ease;
        }
        .button:hover {
            background: #0052A3;
            box-shadow: 0 4px 12px rgba(0, 102, 204, 0.4);
        }
        .button a
        {
            font-size: 14px;
            font-weight: 700;
            color: #FFFFFF;
            text-transform: uppercase;
            line-height: 48px;
            white-space: nowrap;
            -webkit-transition: all 200ms ease;
            -moz-transition: all 200ms ease;
            -ms-transition: all 200ms ease;
            -o-transition: all 200ms ease;
            transition: all 200ms ease;
        }
        .button_1
        {
            background: #0066CC;
        }
        .button_1:hover
        {
            background: #0052A3;
        }
        
        /* Register button white with blue text */
        .register_button.button_1 {
            background: #FFFFFF;
            border: 2px solid #0066CC;
        }
        .register_button.button_1 a {
            color: #0066CC;
            font-weight: 700;
        }
        .register_button.button_1:hover {
            background: #0066CC;
        }
        .register_button.button_1:hover a {
            color: #FFFFFF;
        }
        
        /* Dashboard button same styling */
        .register_button a {
            display: block;
        }
        
        /* Responsive milestones */
        @media (max-width: 991px) {
            .milestone_col {
                padding-top: 40px;
                padding-bottom: 40px;
            }
            .milestone_counter {
                font-size: 30px;
            }
        }
            </style>
    @endpush
    <!-- Hero Slider -->
    <div class="hero_slider_container">
        <div class="hero_slider owl-carousel">
            <!-- Hero Slide 1 -->
            <div class="hero_slide">
                <div class="hero_slide_background" style="background-image:url({{ asset('images/landing/slider_background.jpg') }})"></div>
                <div class="hero_slide_container d-flex flex-column align-items-center justify-content-center">
                    <div class="hero_slide_content text-center">
                        <h1 data-animation-in="fadeInUp" data-animation-out="animate-out fadeOut">
                            Get your <span>Education</span> today!
                        </h1>
                    </div>
                </div>
            </div>
            
            <!-- Hero Slide 2 -->
            <div class="hero_slide">
                <div class="hero_slide_background" style="background-image:url({{ asset('images/landing/slider_background.jpg') }})"></div>
                <div class="hero_slide_container d-flex flex-column align-items-center justify-content-center">
                    <div class="hero_slide_content text-center">
                        <h1 data-animation-in="fadeInUp" data-animation-out="animate-out fadeOut">
                            Learn with <span>Learning Management System SMKN 40</span>
                        </h1>
                    </div>
                </div>
            </div>
            
            <!-- Hero Slide 3 -->
            <div class="hero_slide">
                <div class="hero_slide_background" style="background-image:url({{ asset('images/landing/slider_background.jpg') }})"></div>
                <div class="hero_slide_container d-flex flex-column align-items-center justify-content-center">
                    <div class="hero_slide_content text-center">
                        <h1 data-animation-in="fadeInUp" data-animation-out="animate-out fadeOut">
                            Transform your <span>Future</span> now!
                        </h1>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="hero_slider_left hero_slider_nav trans_200"><span class="trans_200">prev</span></div>
        <div class="hero_slider_right hero_slider_nav trans_200"><span class="trans_200">next</span></div>
    </div>
</div>

<!-- Hero Boxes -->
<div class="hero_boxes">
    <div class="hero_boxes_inner">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 hero_box_col">
                    <div class="hero_box d-flex flex-row align-items-center justify-content-start">
                        <img src="{{ asset('images/landing/earth-globe.svg') }}" class="svg" alt="">
                        <div class="hero_box_content">
                            <h2 class="hero_box_title">Online Courses</h2>
                            <a href="#courses" class="hero_box_link">view more</a>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-4 hero_box_col">
                    <div class="hero_box d-flex flex-row align-items-center justify-content-start">
                        <img src="{{ asset('images/landing/books.svg') }}" class="svg" alt="">
                        <div class="hero_box_content">
                            <h2 class="hero_box_title">Our Library</h2>
                            <a href="#library" class="hero_box_link">view more</a>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-4 hero_box_col">
                    <div class="hero_box d-flex flex-row align-items-center justify-content-start">
                        <img src="{{ asset('images/landing/professor.svg') }}" class="svg" alt="">
                        <div class="hero_box_content">
                            <h2 class="hero_box_title">Our Teachers</h2>
                            <a href="#teachers" class="hero_box_link">view more</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Include Courses Section -->
@include('landing.components.courses-section')

<!-- Register Section -->
<div class="register">
    <div class="container-fluid">
        <div class="row row-eq-height">
            <div class="col-lg-6 nopadding">
                <div class="register_section d-flex flex-column align-items-center justify-content-center">
                    <div class="register_content text-center">
                        <h1 class="register_title">Start learning today! Get <span>30%</span> discount</h1>
                        <p class="register_text">Join thousands of students and start your learning journey with Learning Management System SMKN 40. Transform your skills and advance your career with our comprehensive courses.</p>
                        <div class="button button_1 register_button mx-auto trans_200">
                    @auth
                                <a href="{{ url('/dashboard') }}">Go to Dashboard</a>
                    @else
                                <a href="{{ route('register') }}">Register Now</a>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-6 nopadding">
                <div class="search_section d-flex flex-column align-items-center justify-content-center">
                    <div class="search_background" style="background-image:url({{ asset('images/landing/search_background.jpg') }});"></div>
                    <div class="search_content text-center">
                        <h1 class="search_title">Search for your course</h1>
                        <form id="search_form" class="search_form" action="#" method="POST">
                            @csrf
                            <input id="search_form_name" class="input_field search_form_name" type="text" placeholder="Course Name" required="required">
                            <input id="search_form_category" class="input_field search_form_category" type="text" placeholder="Category">
                            <input id="search_form_degree" class="input_field search_form_degree" type="text" placeholder="Level">
                            <button id="search_submit_button" type="submit" class="search_submit_button trans_200">Search Course</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Services -->
<div class="services page_section" id="services">
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="section_title text-center">
                    <h1>Our Services</h1>
                </div>
            </div>
        </div>
        
        <div class="row services_row">
            <div class="col-lg-4 service_item text-left d-flex flex-column align-items-start justify-content-start">
                <div class="icon_container d-flex flex-column justify-content-end">
                    <img src="{{ asset('images/landing/earth-globe.svg') }}" alt="">
                </div>
                <h3>Online Courses</h3>
                <p>Access thousands of high-quality courses from anywhere in the world. Learn at your own pace with our flexible online platform.</p>
            </div>
            
            <div class="col-lg-4 service_item text-left d-flex flex-column align-items-start justify-content-start">
                <div class="icon_container d-flex flex-column justify-content-end">
                    <img src="{{ asset('images/landing/exam.svg') }}" alt="">
                </div>
                <h3>Interactive Learning</h3>
                <p>Engage with interactive quizzes, assignments, and projects. Get instant feedback and track your progress.</p>
            </div>
            
            <div class="col-lg-4 service_item text-left d-flex flex-column align-items-start justify-content-start">
                <div class="icon_container d-flex flex-column justify-content-end">
                    <img src="{{ asset('images/landing/books.svg') }}" alt="">
                </div>
                <h3>Digital Library</h3>
                <p>Access a vast collection of digital resources, e-books, and study materials to support your learning journey.</p>
            </div>
            
            <div class="col-lg-4 service_item text-left d-flex flex-column align-items-start justify-content-start">
                <div class="icon_container d-flex flex-column justify-content-end">
                    <img src="{{ asset('images/landing/professor.svg') }}" alt="">
                </div>
                <h3>Expert Instructors</h3>
                <p>Learn from industry experts and experienced educators who bring real-world knowledge to your learning experience.</p>
            </div>
            
            <div class="col-lg-4 service_item text-left d-flex flex-column align-items-start justify-content-start">
                <div class="icon_container d-flex flex-column justify-content-end">
                    <img src="{{ asset('images/landing/blackboard.svg') }}" alt="">
                </div>
                <h3>Certification Programs</h3>
                <p>Earn certificates upon course completion that you can add to your professional profile.</p>
            </div>
            
            <div class="col-lg-4 service_item text-left d-flex flex-column align-items-start justify-content-start">
                <div class="icon_container d-flex flex-column justify-content-end">
                    <img src="{{ asset('images/landing/mortarboard.svg') }}" alt="">
                </div>
                <h3>Career Support</h3>
                <p>Get career guidance, resume building tips, and job placement assistance to advance your career.</p>
            </div>
        </div>
    </div>
</div>

<!-- Include Quizzes Section -->
@include('landing.components.quizzes-section')

<!-- Testimonials -->
<div class="testimonials page_section" id="testimonials">
    <div class="testimonials_background_container">
        <div class="testimonials_background" style="background-image:url({{ asset('images/landing/testimonials_background.jpg') }})"></div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="section_title text-center">
                    <h1>What our students say</h1>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-10 offset-lg-1">
                <div class="testimonials_slider_container">
                    <div class="owl-carousel owl-theme testimonials_slider">
                        @forelse($testimonials ?? [] as $testimonial)
                        <div class="owl-item">
                            <div class="testimonials_item text-center">
                                <div class="quote">"</div>
                                <p class="testimonials_text">{{ $testimonial->testimonial_text }}</p>
                                <div class="testimonial_user">
                                    <div class="testimonial_image mx-auto">
                                        @if($testimonial->user->avatar)
                                            <img src="{{ asset('storage/' . $testimonial->user->avatar) }}" alt="{{ $testimonial->user->name }}">
                                        @else
                                            <img src="{{ $testimonial->user->avatar_url }}" alt="{{ $testimonial->user->name }}" onerror="this.src='{{ asset('images/landing/testimonials_user.jpg') }}'">
                                        @endif
                                    </div>
                                    <div class="testimonial_name">{{ $testimonial->user->name }}</div>
                                    <div class="testimonial_title">
                                        @if($testimonial->course)
                                            {{ $testimonial->course->title }}
                                        @else
                                            Student
                                        @endif
                                    </div>
                                    @if($testimonial->rating)
                                    <div class="mt-2" style="color: #ffb606;">
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= $testimonial->rating)
                                                <i class="fas fa-star" style="font-size: 12px;"></i>
                                            @else
                                                <i class="far fa-star" style="font-size: 12px;"></i>
                                            @endif
                                        @endfor
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @empty
                        <!-- Fallback testimonials if no data available -->
                        <div class="owl-item">
                            <div class="testimonials_item text-center">
                                <div class="quote">"</div>
                                <p class="testimonials_text">Learning Management System SMKN 40 has completely transformed my learning experience. The courses are well-structured, the instructors are knowledgeable, and the platform is user-friendly. I've gained valuable skills that have advanced my career significantly.</p>
                                <div class="testimonial_user">
                                    <div class="testimonial_image mx-auto">
                                        <img src="{{ asset('images/landing/testimonials_user.jpg') }}" alt="">
                                    </div>
                                    <div class="testimonial_name">Sarah Johnson</div>
                                    <div class="testimonial_title">Software Developer</div>
                                </div>
                            </div>
                        </div>
                        @endforelse
                    </div>
                </div>
                @if($testimonials && $testimonials->count() > 3)
                <div class="text-center mt-4">
                    <a href="{{ route('testimonials.index') }}" class="button button_outline">
                        <span>View All Testimonials</span>
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Milestones -->
<div class="milestones page_section" id="milestones">
    <div class="milestones_background" style="background-image:url({{ asset('images/landing/milestones_background.jpg') }})"></div>
    <div class="container">
        <div class="row">
            <!-- Milestone -->
            <div class="col-lg-3 milestone_col">
                <div class="milestone text-center">
                    <div class="milestone_icon"><img src="{{ asset('images/landing/milestone_1.svg') }}" alt=""></div>
                    <div class="milestone_counter" data-end-value="{{ $totalStudents ?? 0 }}">0</div>
                    <div class="milestone_text">Students</div>
                </div>
            </div>
            
            <!-- Milestone -->
            <div class="col-lg-3 milestone_col">
                <div class="milestone text-center">
                    <div class="milestone_icon"><img src="{{ asset('images/landing/milestone_2.svg') }}" alt=""></div>
                    <div class="milestone_counter" data-end-value="{{ $totalCourses ?? 0 }}">0</div>
                    <div class="milestone_text">Courses</div>
                </div>
            </div>
            
            <!-- Milestone -->
            <div class="col-lg-3 milestone_col">
                <div class="milestone text-center">
                    <div class="milestone_icon"><img src="{{ asset('images/landing/milestone_3.svg') }}" alt=""></div>
                    <div class="milestone_counter" data-end-value="{{ $totalTeachers ?? 0 }}">0</div>
                    <div class="milestone_text">Teachers</div>
                </div>
            </div>
            
            <!-- Milestone -->
            <div class="col-lg-3 milestone_col">
                <div class="milestone text-center">
                    <div class="milestone_icon"><img src="{{ asset('images/landing/milestone_4.svg') }}" alt=""></div>
                    <div class="milestone_counter" data-end-value="99">0</div>
                    <div class="milestone_text">Success Rate %</div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Events -->
<div class="events page_section" id="events">
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="section_title text-center">
                    <h1>Upcoming Events</h1>
                </div>
            </div>
        </div>

        <div class="event_items">
            <!-- Event 1 -->
            <div class="row event_item">
                <div class="col">
                    <div class="row d-flex flex-row align-items-end">
                        <div class="col-lg-2 order-lg-1 order-2">
                            <div class="event_date d-flex flex-column align-items-center justify-content-center">
                                <div class="event_day">15</div>
                                <div class="event_month">January</div>
                            </div>
                        </div>
                        
                        <div class="col-lg-6 order-lg-2 order-3">
                            <div class="event_content">
                                <div class="event_name"><a class="trans_200" href="#">Web Development Workshop</a></div>
                                <div class="event_location">Online Event</div>
                                <p>Join our free workshop to learn the fundamentals of web development. Perfect for beginners.</p>
                            </div>
                        </div>
                        
                        <div class="col-lg-4 order-lg-3 order-1">
                            <div class="event_image">
                                <img src="{{ asset('images/landing/event_1.jpg') }}" alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Event 2 -->
            <div class="row event_item">
                <div class="col">
                    <div class="row d-flex flex-row align-items-end">
                        <div class="col-lg-2 order-lg-1 order-2">
                            <div class="event_date d-flex flex-column align-items-center justify-content-center">
                                <div class="event_day">22</div>
                                <div class="event_month">January</div>
                            </div>
                        </div>
                        
                        <div class="col-lg-6 order-lg-2 order-3">
                            <div class="event_content">
                                <div class="event_name"><a class="trans_200" href="#">Data Science Bootcamp</a></div>
                                <div class="event_location">Online Event</div>
                                <p>Intensive bootcamp covering data analysis, machine learning, and visualization techniques.</p>
                            </div>
                        </div>
                        
                        <div class="col-lg-4 order-lg-3 order-1">
                            <div class="event_image">
                                <img src="{{ asset('images/landing/event_2.jpg') }}" alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Event 3 -->
            <div class="row event_item">
                <div class="col">
                    <div class="row d-flex flex-row align-items-end">
                        <div class="col-lg-2 order-lg-1 order-2">
                            <div class="event_date d-flex flex-column align-items-center justify-content-center">
                                <div class="event_day">28</div>
                                <div class="event_month">January</div>
                            </div>
                        </div>
                        
                        <div class="col-lg-6 order-lg-2 order-3">
                            <div class="event_content">
                                <div class="event_name"><a class="trans_200" href="#">Career Networking Event</a></div>
                                <div class="event_location">Online Event</div>
                                <p>Connect with industry professionals and learn about career opportunities in tech.</p>
                            </div>
                        </div>
                        
                        <div class="col-lg-4 order-lg-3 order-1">
                            <div class="event_image">
                                <img src="{{ asset('images/landing/event_3.jpg') }}" alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('js/landing/custom.js') }}"></script>
<script>
$(document).ready(function() {
    'use strict';
    
    // Initialize milestone counters
    if($('.milestone_counter').length) {
        var milestoneItems = $('.milestone_counter');
        
        milestoneItems.each(function(i) {
            var ele = $(this);
            var endValue = parseInt(ele.data('end-value'));
            var signBefore = ele.data('sign-before') || '';
            var signAfter = ele.data('sign-after') || '';
            
            if(endValue > 0) {
                var counter = {value: 0};
                var counterTween = TweenMax.to(counter, 2, {
                    value: endValue,
                    roundProps: {value},
                    ease: Power2.easeOut,
                    onUpdate: function() {
                        document.getElementsByClassName('milestone_counter')[i].innerHTML = signBefore + counter.value + signAfter;
                    }
                });
                
                var milestoneScene = new ScrollMagic.Scene({
                    triggerElement: ele[0],
                    triggerHook: 0.8,
                    duration: 0
                })
                .setTween(counterTween)
                .addTo(ctrl);
            }
        });
    }
});
</script>
@endpush
