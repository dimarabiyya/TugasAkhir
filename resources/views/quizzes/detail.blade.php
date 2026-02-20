@extends('layouts.landing')

@section('content')
@php
use Illuminate\Support\Str;
use Carbon\Carbon;
@endphp

<!-- Home -->
<div class="home">
    <div class="home_background_container prlx_parent">
        <div class="home_background prlx" style="background-image:url({{ asset('images/landing/news_background.jpg') }})"></div>
    </div>
    <div class="home_content">
        <h1>Quiz Details</h1>
    </div>
</div>

<!-- News -->
<div class="news">
    <div class="container">
        <div class="row">
            
            <!-- Quiz Post Column -->
            <div class="col-lg-8">
                
                <div class="news_post_container">
                    <!-- Quiz Post -->
                    <div class="news_post">
                        <div class="news_post_image">
                            @if(optional($quiz->lesson)->module->course && optional($quiz->lesson->module->course)->thumbnail)
                                <img src="{{ asset('storage/' . $quiz->lesson->module->course->thumbnail) }}" alt="{{ $quiz->title }}">
                            @else
                                <img src="{{ asset('images/landing/news_1.jpg') }}" alt="{{ $quiz->title }}">
                            @endif
                        </div>
                        <div class="news_post_top d-flex flex-column flex-sm-row">
                            <div class="news_post_date_container">
                                <div class="news_post_date d-flex flex-column align-items-center justify-content-center">
                                    <div>{{ $quiz->created_at->format('d') }}</div>
                                    <div>{{ strtolower($quiz->created_at->format('M')) }}</div>
                                </div>
                            </div>
                            <div class="news_post_title_container">
                                <div class="news_post_title">
                                    <a href="#">{{ $quiz->title }}</a>
                                </div>
                                <div class="news_post_meta">
                                    <span class="news_post_author">
                                        @if(optional($quiz->lesson)->module->course)
                                            <a href="{{ route('courses.detail', $quiz->lesson->module->course) }}">{{ $quiz->lesson->module->course->title }}</a>
                                        @else
                                            <a href="#">Smart Edu</a>
                                        @endif
                                    </span>
                                    <span>|</span>
                                    <span class="news_post_comments">
                                        <a href="#">{{ $quiz->questions_count ?? 0 }} Questions</a>
                                    </span>
                                </div>
                            </div>
                        </div>
                        
                        @if($quiz->description)
                        <div class="news_post_text">
                            <p>{!! nl2br(e($quiz->description)) !!}</p>
                        </div>
                        @endif

                        <!-- Quiz Instructions -->
                        @if($quiz->instructions)
                        <div class="news_post_quote">
                            <p class="news_post_quote_text"><span>I</span>{{ Str::limit($quiz->instructions, 200) }}</p>
                        </div>
                        @endif

                        <!-- Quiz Rules -->
                        <div class="news_post_text" style="margin-top: 40px;">
                            <h4 class="mb-3" style="color: #1e40af; font-weight: 600;">Aturan & Persyaratan Kuis</h4>
                            
                            <ul style="line-height: 2; color: #555; padding-left: 20px;">
                                <li class="mb-2"><strong>Total Questions:</strong> {{ $quiz->questions_count }} questions</li>
                                
                                @if($quiz->passing_score)
                                <li class="mb-2"><strong>Passing Score:</strong> {{ $quiz->passing_score }}% is required to pass</li>
                                @endif
                                
                                @if($quiz->time_limit_minutes)
                                <li class="mb-2"><strong>Time Limit:</strong> You have {{ $quiz->time_limit_minutes }} minutes to complete</li>
                                @endif
                                
                                @if(!$quiz->allow_navigation)
                                <li class="mb-2"><strong>Navigation:</strong> You cannot go back to previous questions</li>
                                @endif
                                
                                @if($quiz->shuffle_questions)
                                <li class="mb-2"><strong>Urutan Pertanyaan:</strong> Pertanyaan akan muncul dalam urutan acak</li>
                                @endif
                                
                                @if($quiz->shuffle_answers)
                                <li class="mb-2"><strong>Urutan Jawaban:</strong> Opsi jawaban akan diacak secara acak</li>
                                @endif
                                
                                @if($quiz->negative_marking)
                                <li class="mb-2"><strong>Penilaian Negatif:</strong> Jawaban yang salah mengurangi {{ $quiz->negative_mark_value ?? 1 }} poin</li>
                                @endif
                                
                                @if($quiz->require_all_questions)
                                <li class="mb-2"><strong>Wajib:</strong> Semua pertanyaan harus dijawab sebelum pengajuan</li>
                                @endif
                                
                                @if($quiz->allow_multiple_attempts)
                                <li class="mb-2"><strong>Upaya Ganda:</strong> Anda dapat mengikuti kuis ini beberapa kali
                                    @if($quiz->max_attempts) (Max {{ $quiz->max_attempts }}) @endif
                                </li>
                                @else
                                <li class="mb-2"><strong>Upaya Tunggal:</strong> Anda hanya dapat mengikuti kuis ini sekali</li>
                                @endif
                            </ul>
                        </div>

                        <!-- Pass/Fail Messages -->
                        @if($quiz->pass_message || $quiz->fail_message)
                        <div class="news_post_text" style="margin-top: 40px;">
                            @if($quiz->pass_message)
                            <div class="mb-3 p-3" style="background: #d4edda; border-left: 4px solid #28a745; border-radius: 4px;">
                                <strong class="text-success">
                                    <i class="fas fa-check-circle mr-2"></i>Pesan Lulus
                                </strong>
                                <p class="mb-0 mt-2">{{ $quiz->pass_message }}</p>
                            </div>
                            @endif
                            
                            @if($quiz->fail_message)
                            <div class="mb-3 p-3" style="background: #f8d7da; border-left: 4px solid #dc3545; border-radius: 4px;">
                                <strong class="text-danger">
                                    <i class="fas fa-times-circle mr-2"></i>Pesan Gagal
                                </strong>
                                <p class="mb-0 mt-2">{{ $quiz->fail_message }}</p>
                            </div>
                            @endif
                        </div>
                        @endif

                        <!-- Result Visibility -->
                        <div class="news_post_text" style="margin-top: 40px;">
                            <h4 class="mb-3" style="color: #1e40af; font-weight: 600;">Visibilitas Hasil</h4>
                            
                            @if($quiz->show_results_immediately)
                            <p class="mb-2">
                                <i class="fas fa-check text-success mr-2"></i>
                                <strong>Hasil:</strong> Anda akan melihat skor Anda segera setelah pengajuan
                            </p>
                            @endif
                            
                            @if($quiz->show_correct_answers)
                            <p class="mb-0">
                                <i class="fas fa-check text-success mr-2"></i>
                                <strong>Jawaban:</strong> Jawaban yang benar akan ditampilkan setelah Anda menyelesaikan kuis
                            </p>
                            @else
                            <p class="mb-0 text-muted">
                                <i class="fas fa-times text-danger mr-2"></i>
                                <strong>Jawaban:</strong> Jawaban yang benar tidak akan ditampilkan
                            </p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar Column -->
            <div class="col-lg-4">
                <div class="sidebar">

                    <!-- Ready to Start -->
                    <div class="sidebar_section">
                        <div class="sidebar_section_title">
                            <h3>Siap Memulai?</h3>
                        </div>
                        
                        @if($quiz->time_limit_minutes)
                        <p class="text-muted mb-4" style="text-align: center;">
                            <i class="fas fa-clock mr-2" style="color: #ffb606;"></i>
                            Anda akan memiliki {{ $quiz->time_limit_minutes }} menit
                        </p>
                        @endif
                        
                        @auth
                            @php
                                $userAttempts = $quiz->attempts()->where('user_id', auth()->id())->count();
                                $canAttempt = $quiz->canUserAttempt(auth()->id());
                            @endphp
                            
                            @if($canAttempt)
                                @if($userAttempts > 0)
                                    <div class="alert alert-info mb-4" style="font-size: 0.9rem; padding: 12px;">
                                        <i class="fas fa-info-circle mr-2"></i>
                                        Upaya {{ $userAttempts + 1 }} dari {{ $quiz->max_attempts ?? 'Tidak Terbatas' }}
                                    </div>
                                @endif
                                <div class="button button_1 mb-3" style="width: 100%;">
                                    <a href="{{ route('quizzes.show', $quiz) }}">Mulai Kuis</a>
                                </div>
                            @else
                                <div class="alert alert-warning mb-4" style="font-size: 0.9rem; padding: 12px;">
                                    <i class="fas fa-exclamation-triangle mr-2"></i>
                                    @if($quiz->max_attempts)
                                        Upaya maksimal tercapai
                                    @else
                                        Kuis sudah selesai
                                    @endif
                                </div>
                                <div class="button button_outline mb-3" style="width: 100%;">
                                    <a href="{{ route('quizzes.show', $quiz) }}">Lihat Hasil</a>
                                </div>
                            @endif
                        @else
                            <div class="button button_1 mb-3" style="width: 100%;">
                                <a href="{{ route('login') }}">Login untuk Mengikuti Kuis</a>
                            </div>
                            <div class="button button_outline mb-3" style="width: 100%;">
                                <a href="{{ route('register') }}">Buat Akun</a>
                            </div>
                        @endauth
                    </div>

                    <!-- Related Course -->
                    @if(optional($quiz->lesson)->module->course)
                    <div class="sidebar_section">
                        <div class="sidebar_section_title">
                            <h3>Mata Pelajaran Terkait</h3>
                        </div>
                        <div class="latest_post">
                            @if($quiz->lesson->module->course->thumbnail)
                            <div class="latest_post_image">
                                <img src="{{ asset('storage/' . $quiz->lesson->module->course->thumbnail) }}" alt="{{ $quiz->lesson->module->course->title }}">
                            </div>
                            @endif
                            <div class="latest_post_title">
                                <a href="{{ route('courses.detail', $quiz->lesson->module->course) }}">{{ $quiz->lesson->module->course->title }}</a>
                            </div>
                            <div class="latest_post_meta">
                                <span class="latest_post_author">
                                    <a href="{{ route('courses.detail', $quiz->lesson->module->course) }}">View Course</a>
                                </span>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Quiz Stats -->
                    <div class="sidebar_section">
                        <div class="sidebar_section_title">
                            <h3>Statistik Kuis</h3>
                        </div>
                        <ul class="sidebar_list">
                            <li class="sidebar_list_item">
                                <strong>Pertanyaan:</strong> {{ $quiz->questions_count }}
                            </li>
                            @if($quiz->passing_score)
                            <li class="sidebar_list_item">
                                <strong>Skor Kelulusan:</strong> {{ $quiz->passing_score }}%
                            </li>
                            @endif
                            @if($quiz->time_limit_minutes)
                            <li class="sidebar_list_item">
                                <strong>Batas Waktu:</strong> {{ $quiz->time_limit_minutes }} min
                            </li>
                            @endif
                            <li class="sidebar_list_item">
                                <strong>Upaya:</strong> {{ $quiz->attempts()->count() }}
                            </li>
                        </ul>
                    </div>

                    <!-- Tags -->
                    <div class="sidebar_section">
                        <div class="sidebar_section_title">
                            <h3>Tag</h3>
                        </div>
                        <div class="tags d-flex flex-row flex-wrap">
                            <div class="tag"><a href="#">Kuis</a></div>
                            <div class="tag"><a href="#">Tes</a></div>
                            <div class="tag"><a href="#">Praktik</a></div>
                            <div class="tag"><a href="#">Ujian</a></div>
                            <div class="tag"><a href="#">Penilaian</a></div>
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
