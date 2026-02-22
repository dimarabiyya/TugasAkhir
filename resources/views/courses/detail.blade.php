@extends('layouts.landing')

@section('content')
@php
use Illuminate\Support\Str;
@endphp

<div class="home">
    <div class="home_background_container prlx_parent">
        <div class="home_background prlx" style="background-image:url({{ asset('images/landing/courses_background.jpg') }})"></div>
    </div>
    <div class="home_content">
        <h1>Detail Kursus</h1>
    </div>
</div>

<div class="news">
    <div class="container">
        <div class="row">
            
            <div class="col-lg-8">
                
                <div class="news_post_container">
                    <div class="news_post">
                        <div class="news_post_image">
                            @if($course->thumbnail)
                                <img src="{{ asset('storage/' . $course->thumbnail) }}" alt="{{ $course->title }}">
                            @else
                                <img src="{{ asset('images/landing/course_1.jpg') }}" alt="{{ $course->title }}">
                            @endif
                        </div>
                        <div class="news_post_top d-flex flex-column flex-sm-row">
                            <div class="news_post_date_container">
                                <div class="news_post_date d-flex flex-column align-items-center justify-content-center">
                                    <div>{{ $course->created_at->format('d') }}</div>
                                    <div>{{ strtolower($course->created_at->translatedFormat('M')) }}</div>
                                </div>
                            </div>
                            <div class="news_post_title_container">
                                <div class="news_post_title">
                                    <a href="#">{{ $course->title }}</a>
                                </div>
                                <div class="news_post_meta">
                                    <span class="news_post_author">
                                        @if($course->instructor)
                                            <a href="{{ route('landing.teachers') }}">{{ $course->instructor->name }}</a>
                                        @else
                                            <a href="#">Smart Edu</a>
                                        @endif
                                    </span>
                                    <span>|</span>
                                    <span class="news_post_comments">
                                        <a href="#">{{ $course->modules->count() }} Modul</a>
                                    </span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="news_post_text">
                            <p>{!! nl2br(e($course->description)) !!}</p>
                        </div>

                        <div class="news_post_quote">
                            <p class="news_post_quote_text"><span>A</span>pa yang akan Anda pelajari dalam kursus komprehensif ini yang dirancang khusus untuk siswa tingkat {{ $course->level == 'beginner' ? 'Pemula' : ($course->level == 'intermediate' ? 'Menengah' : 'Mahir') }}.</p>
                        </div>

                        <div class="news_post_text" style="margin-top: 40px;">
                            <h4 class="mb-4" style="color: #1e40af; font-weight: 600;">Kurikulum Kursus</h4>
                            
                            @forelse($course->modules as $index => $module)
                            <div class="mb-4" style="border-left: 4px solid #ffb606; padding-left: 20px; padding-top: 10px; padding-bottom: 10px;">
                                <h5 class="mb-2" style="color: #1e40af;">
                                    <span style="background: #ffb606; color: white; width: 30px; height: 30px; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; margin-right: 10px; font-size: 14px;">{{ $index + 1 }}</span>
                                    {{ $module->title }}
                                </h5>
                                @if($module->description)
                                <p class="text-muted mb-2">{{ $module->description }}</p>
                                @endif
                                <p class="mb-0">
                                    <i class="fas fa-book mr-2" style="color: #ffb606;"></i>
                                    <strong>{{ $module->lessons->count() }}</strong> Materi Pelajaran
                                </p>
                                
                                @if($module->lessons->count() > 0)
                                <ul class="mt-3 mb-0" style="padding-left: 30px; line-height: 2;">
                                    @foreach($module->lessons as $lesson)
                                    <li style="color: #555;">
                                        <i class="fas fa-play-circle mr-2" style="color: #ffb606; font-size: 12px;"></i>
                                        {{ $lesson->title }}
                                        @if($lesson->duration_minutes)
                                        <span class="text-muted ml-2">
                                            <i class="fas fa-clock"></i> {{ $lesson->duration_minutes }} menit
                                        </span>
                                        @endif
                                    </li>
                                    @endforeach
                                </ul>
                                @endif
                            </div>
                            @empty
                            <p class="text-muted">Belum ada modul yang tersedia.</p>
                            @endforelse
                        </div>

                        <div class="news_post_text" style="margin-top: 40px;">
                            <h4 class="mb-3" style="color: #1e40af; font-weight: 600;">Manfaat Kursus</h4>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <p class="mb-0">
                                        <i class="fas fa-certificate mr-2" style="color: #ffb606;"></i>
                                        <strong>Dapatkan Sertifikat</strong> - Peroleh sertifikat kelulusan
                                    </p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <p class="mb-0">
                                        <i class="fas fa-wifi mr-2" style="color: #ffb606;"></i>
                                        <strong>Belajar Online</strong> - Belajar sesuai kecepatan Anda
                                    </p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <p class="mb-0">
                                        <i class="fas fa-headset mr-2" style="color: #ffb606;"></i>
                                        <strong>Dukungan Ahli</strong> - Bantuan langsung dari instruktur
                                    </p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <p class="mb-0">
                                        <i class="fas fa-sync-alt mr-2" style="color: #ffb606;"></i>
                                        <strong>Akses Selamanya</strong> - Akses materi tanpa batas waktu
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="sidebar">

                    <div class="sidebar_section">
                        <div class="sidebar_section_title">
                            <h3>Gabung Sekarang</h3>
                        </div>
                        <div class="mb-4 text-center">
                            <h2 class="mb-3" style="color: #ffb606; font-weight: 700;">
                                @if($course->price == 0)
                                    GRATIS
                                @else
                                    Rp{{ number_format($course->price, 0, ',', '.') }}
                                @endif
                            </h2>
                            <p class="text-muted mb-4">Mulai perjalanan belajar Anda hari ini!</p>
                        </div>
                        
                        @auth
                            @php
                                $enrolled = auth()->user()->courses()->where('course_id', $course->id)->exists();
                            @endphp
                            @if($enrolled)
                                <div class="button button_1 mb-3" style="width: 100%;">
                                    <a href="{{ route('courses.show', $course) }}">Lanjutkan Belajar</a>
                                </div>
                            @else
                                <div class="button button_1 mb-3" style="width: 100%;">
                                    <a href="{{ route('courses.show', $course) }}">Daftar Sekarang</a>
                                </div>
                            @endif
                        @else
                            <div class="button button_1 mb-3" style="width: 100%;">
                                <a href="{{ route('login') }}">Login untuk Daftar</a>
                            </div>
                            <div class="button button_outline mb-3" style="width: 100%;">
                                <a href="{{ route('register') }}">Buat Akun Baru</a>
                            </div>
                        @endauth
                    </div>

                    <div class="sidebar_section">
                        <div class="sidebar_section_title">
                            <h3>Statistik Kursus</h3>
                        </div>
                        <ul class="sidebar_list">
                            <li class="sidebar_list_item">
                                <strong>Modul:</strong> {{ $course->modules->count() }}
                            </li>
                            <li class="sidebar_list_item">
                                <strong>Pelajaran:</strong> {{ $course->lessons_count }}
                            </li>
                            <li class="sidebar_list_item">
                                <strong>Durasi:</strong> {{ $course->duration_hours ?? 0 }} Jam
                            </li>
                            <li class="sidebar_list_item">
                                <strong>Tingkat:</strong> {{ $course->level == 'beginner' ? 'Pemula' : ($course->level == 'intermediate' ? 'Menengah' : 'Mahir') }}
                            </li>
                            <li class="sidebar_list_item">
                                <strong>Bahasa:</strong> Indonesia
                            </li>
                        </ul>
                    </div>

                    @php
                        $latestCourses = \App\Models\Course::where('is_published', true)
                            ->where('id', '!=', $course->id)
                            ->orderBy('created_at', 'desc')
                            ->take(3)
                            ->get();
                    @endphp
                    @if($latestCourses->count() > 0)
                    <div class="sidebar_section">
                        <div class="sidebar_section_title">
                            <h3>Kursus Terbaru</h3>
                        </div>
                        <div class="latest_posts">
                            @foreach($latestCourses as $latestCourse)
                            <div class="latest_post">
                                @if($latestCourse->thumbnail)
                                <div class="latest_post_image">
                                    <img src="{{ asset('storage/' . $latestCourse->thumbnail) }}" alt="{{ $latestCourse->title }}">
                                </div>
                                @endif
                                <div class="latest_post_title">
                                    <a href="{{ route('courses.detail', $latestCourse) }}">{{ $latestCourse->title }}</a>
                                </div>
                                <div class="latest_post_meta">
                                    <span class="latest_post_author">
                                        <a href="{{ route('courses.detail', $latestCourse) }}">Lihat Kursus</a>
                                    </span>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <div class="sidebar_section">
                        <div class="sidebar_section_title">
                            <h3>Tagar</h3>
                        </div>
                        <div class="tags d-flex flex-row flex-wrap">
                            <div class="tag"><a href="#">{{ $course->level == 'beginner' ? 'Pemula' : ($course->level == 'intermediate' ? 'Menengah' : 'Mahir') }}</a></div>
                            <div class="tag"><a href="#">Kursus</a></div>
                            <div class="tag"><a href="#">Belajar</a></div>
                            <div class="tag"><a href="#">Edukasi</a></div>
                            <div class="tag"><a href="#">Online</a></div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<link rel="stylesheet" type="text/css" href="{{ asset('css/landing/news_post_styles.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('css/landing/news_post_responsive.css') }}">
@endpush

@push('scripts')
<script src="{{ asset('js/landing/news_post_custom.js') }}"></script>
@endpush
@endsection