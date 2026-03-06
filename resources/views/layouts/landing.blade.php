<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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

    <!-- Tailwind paling bawah -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    @stack('styles')
    
    <link href="images/landing/Logo40.png" type="" rel="shortcut icon">
    @stack('styles')
    
    <style>
        body {
            font-family: 'Roboto', sans-serif;
        }
    </style>
</head>
<body>
    <div class="super_container">

  {{-- ── HEADER ── --}}
  <header class="fixed top-0 w-full z-50" style="background:rgba(15,23,42,0.9);backdrop-filter:blur(16px);border-bottom:1px solid rgba(255,255,255,0.07)">
    <div class="max-w-6xl mx-auto px-6 py-3 flex items-center justify-between">

      {{-- Logo --}}
      <a href="{{ route('welcome') }}" class="flex items-center gap-3 no-underline">
        <img src="{{ asset('images/landing/Logo40.png') }}" alt="SMKN 40 Jakarta" class="w-10 h-10 rounded-xl object-cover">
        <div>
          <div class="text-white font-bold text-sm leading-none" style="font-family:'Sora',sans-serif">SMKN 40</div>
          <div class="text-blue-400 text-xs font-medium">Jakarta</div>
        </div>
      </a>

      {{-- Nav Desktop --}}
      <nav class="hidden md:flex items-center gap-8">
        <a href="#home" class="text-slate-300 hover:text-white text-sm font-medium transition-colors no-underline">Home</a>
        <a href="#fitur" class="text-slate-300 hover:text-white text-sm font-medium transition-colors no-underline">Fitur</a>
        <a href="#login" class="text-slate-300 hover:text-white text-sm font-medium transition-colors no-underline">FAQ</a>
        <li><a href="#tentangkami" class="text-slate-300 hover:text-white text-sm font-medium transition-colors no-underline">Tentang Kami</a></li>
      </nav>

      {{-- Login Button --}}
      <div class="flex items-center gap-3">
        <a href="{{ route('login') }}"
           class="inline-flex items-center gap-2 text-white font-bold text-sm px-5 py-2.5 rounded-xl no-underline transition-all"
           style="background:linear-gradient(135deg,#2563eb,#1d4ed8);box-shadow:0 4px 14px rgba(37,99,235,0.35)">
          Login <i class="mdi mdi-arrow-right"></i>
        </a>

        {{-- Mobile menu toggle --}}
        <button id="mobileMenuBtn" class="md:hidden text-white text-2xl">
          <i class="mdi mdi-menu"></i>
        </button>
      </div>
    </div>

    {{-- Mobile Nav --}}
    <div id="mobileMenu" class="hidden md:hidden px-6 pb-4 border-t border-white/10">
      <nav class="flex flex-col gap-3 pt-4">
        <a href="#home" class="text-slate-300 hover:text-white text-sm font-medium transition-colors no-underline">Home</a>
        <a href="#fitur" class="text-slate-300 hover:text-white text-sm font-medium transition-colors no-underline">Fitur</a>
        <a href="#login" class="text-slate-300 hover:text-white text-sm font-medium transition-colors no-underline">FAQ</a>
        <a href="#tentangkami" class="text-slate-300 hover:text-white text-sm font-medium transition-colors no-underline">Tentang Kami</a>
      </nav>
    </div>
  </header>

  {{-- ── MAIN CONTENT ── --}}
  @yield('content')

  {{-- ── FOOTER ── --}}
  <footer class="bg-slate-900 pt-16 pb-0" style="border-top:1px solid rgba(255,255,255,0.07)">
    <div class="max-w-6xl mx-auto px-6">

      {{-- Footer Content --}}
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10 pb-12" style="border-bottom:1px solid rgba(255,255,255,0.07)">

        {{-- About --}}
        <div>
          <div class="flex items-center gap-3 mb-4">
            <img src="{{ asset('images/landing/Logo40.png') }}" alt="SMKN 40" class="w-12 h-12 rounded-xl object-cover">
            <div>
              <div class="text-white font-bold text-sm" style="font-family:'Sora',sans-serif">LMS SMKN 40</div>
              <div class="text-slate-400 text-xs">Jakarta</div>
            </div>
          </div>
          <p class="text-slate-400 text-sm leading-relaxed">Platform manajemen pembelajaran digital untuk siswa dan guru SMKN 40 Jakarta.</p>
        </div>

        {{-- Menu --}}
        <div>
          <div class="text-white font-bold text-sm mb-4" style="font-family:'Sora',sans-serif">Menu</div>
          <ul class="space-y-2.5 list-none p-0 m-0">
            <li><a href="#home" class="text-slate-400 hover:text-white text-sm transition-colors no-underline">Home</a></li>
            <li><a href="#fitur" class="text-slate-400 hover:text-white text-sm transition-colors no-underline">Fitur</a></li>
            <li><a href="#login" class="text-slate-400 hover:text-white text-sm transition-colors no-underline">FAQ</a></li>
            <li><a href="#tentangkami" class="text-slate-300 hover:text-white text-sm font-medium transition-colors no-underline">Tentang Kami</a></li>
          </ul>
        </div>

        {{-- Useful Links --}}
        <div>
          <div class="text-white font-bold text-sm mb-4" style="font-family:'Sora',sans-serif">Tautan</div>
          <ul class="space-y-2.5 list-none p-0 m-0">
            <li><a href="https://smknegeri40-jkt.sch.id" class="text-slate-400 hover:text-white text-sm transition-colors no-underline">Tentang SMKN 40 Jakarta</a></li>
            <li><a href="https://tefa.smknegeri40-jkt.sch.id" class="text-slate-400 hover:text-white text-sm transition-colors no-underline">Teachcing Factory</a></li>
            <li><a href="https://smknegeri40-jkt.sch.id/ekstrakurikuler/" class="text-slate-400 hover:text-white text-sm transition-colors no-underline">Ekstra Kulikuler</a></li>
            <li><a href="https://smknegeri40-jkt.sch.id/saran/" class="text-slate-400 hover:text-white text-sm transition-colors no-underline">Bantuan</a></li>
          </ul>
        </div>

        {{-- Contact --}}
        <div>
          <div class="text-white font-bold text-sm mb-4" style="font-family:'Sora',sans-serif">Kontak</div>
          <ul class="space-y-3 list-none p-0 m-0">
            <li class="flex items-start gap-3">
              <i class="mdi mdi-map-marker text-blue-400 text-lg mt-0.5"></i>
              <span class="text-slate-400 text-sm">Jakarta, Indonesia</span>
            </li>
            <li class="flex items-start gap-3">
              <i class="mdi mdi-phone text-blue-400 text-lg mt-0.5"></i>
              <span class="text-slate-400 text-sm">+62 234 5678 910</span>
            </li>
            <li class="flex items-start gap-3">
              <i class="mdi mdi-email text-blue-400 text-lg mt-0.5"></i>
              <span class="text-slate-400 text-sm">smkn40jakarta@gmail.com</span>
            </li>
          </ul>
        </div>
      </div>

      {{-- Footer Bar --}}
      <div class="py-6 flex flex-col sm:flex-row items-center justify-between gap-4">
        <span class="text-slate-500 text-sm">© {{ date('Y') }} Learning Management System SMKN 40. All rights reserved.</span>

        {{-- Social --}}
        <div class="flex items-center gap-3">
          @foreach([
            ['fab fa-pinterest','#'],
            ['fab fa-linkedin-in','#'],
            ['fab fa-instagram','#'],
            ['fab fa-facebook-f','#'],
            ['fab fa-twitter','#'],
          ] as $s)
          <a href="{{ $s[1] }}"
             class="w-8 h-8 rounded-lg flex items-center justify-center text-slate-400 hover:text-white transition-all no-underline"
             style="background:rgba(255,255,255,0.05);border:1px solid rgba(255,255,255,0.08)">
            <i class="{{ $s[0] }} text-xs"></i>
          </a>
          @endforeach
        </div>
      </div>
    </div>
  </footer>

</div>


<script>
  // Mobile menu toggle
  const btn  = document.getElementById('mobileMenuBtn');
  const menu = document.getElementById('mobileMenu');
  btn?.addEventListener('click', () => {
    menu.classList.toggle('hidden');
    btn.querySelector('i').classList.toggle('mdi-menu');
    btn.querySelector('i').classList.toggle('mdi-close');
  });

  // Navbar scroll effect
  window.addEventListener('scroll', () => {
    const header = document.querySelector('header');
    if (header) {
      header.style.background = window.scrollY > 30
        ? 'rgba(15,23,42,0.98)'
        : 'rgba(15,23,42,0.9)';
    }
  });
</script>

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

