@extends('layouts.landing')

@section('content')
<!-- Home Section -->
<div class="hero_slider_container">
        <div class="hero_slider owl-carousel">
            <!-- Hero Slide 1 -->
            <div class="hero_slide">
                <div class="hero_slide_background" style="background-image:url({{ asset('images/landing/slider_background.jpg') }})"></div>
                <div class="hero_slide_container d-flex flex-column align-items-center justify-content-center">
                    <div class="hero_slide_content text-center">
                        <h1 data-animation-in="fadeInUp" data-animation-out="animate-out fadeOut">
                            LMS <span>SMKN 40 Jakarta</span>
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
                            LMS <span>SMKN 40 Jakarta</span>
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
                            LMS <span>SMKN 40 Jakarta</span>
                        </h1>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="hero_slider_left hero_slider_nav trans_200"><span class="trans_200">prev</span></div>
        <div class="hero_slider_right hero_slider_nav trans_200"><span class="trans_200">next</span></div>
    </div>
</div>

<div class="px-4 pt-5 my-5 text-center border-bottom" style="margin-top:100px"> 
    <h1 class="display-4 fw-bold text-body-emphasis">Learning Management System</h1> 
    <div class="col-lg-6 mx-auto"> 
        <p class="lead mb-4">Siap Membantu manajemen sekolah dan siswa</p>
        <div class="d-grid gap-2 d-sm-flex justify-content-sm-center mb-5"> 
            <button type="button" class="btn btn-primary btn-lg px-4 me-sm-3">Primary button</button> 
            <button type="button" class="btn btn-outline-secondary btn-lg px-4">Secondary</button> 
        </div> 
    </div> 
    <div class="overflow-hidden" style="max-height: 30vh;"> 
        <div class="container px-5"> 
            <img src="bootstrap-docs.png" class="img-fluid border rounded-3 shadow-lg mb-4" alt="Example image" width="700" height="500" loading="lazy"> 
        </div> 
    </div> 
 </div>
    
@endsection

@push('scripts')
<script src="{{ asset('js/landing/custom.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/@tailwindplus/elements@1" type="module"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.min.js" integrity="sha384-G/EV+4j2dNv+tEPo3++6LCgdCROaejBqfUeNjuKAiuXbjrxilcCdDz6ZAVfHWe1Y" crossorigin="anonymous"></script>
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
