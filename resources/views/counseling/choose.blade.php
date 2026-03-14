@extends('layouts.skydash')

@section('content')

{{-- ===== PAGE HEADER ===== --}}
<div class="row mb-4">
    <div class="col-12">
        <div class="card border-0 shadow-sm" style="background: linear-gradient(135deg, #4e73df 0%, #224abe 100%); border-radius: 12px;">
            <div class="card-body py-4 px-4">
                <div class="row align-items-center">
                    <div class="col-12 col-xl-8 mb-3 mb-xl-0">
                        <div class="d-flex align-items-center">
                            <div style="background: rgba(255,255,255,0.2); border-radius: 10px; width: 48px; height: 48px; display: flex; align-items: center; justify-content: center; margin-right: 14px; flex-shrink: 0;">
                                <i class="mdi mdi-account-search-outline text-white" style="font-size: 26px;"></i>
                            </div>
                            <div>
                                <h4 class="font-weight-bold text-white mb-0">Pilih Guru Konseling</h4>
                                <p class="text-white-50 mb-0" style="font-size: 13px;">Pilih guru yang ingin kamu ajak konsultasi</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-xl-4 d-flex justify-content-xl-end">
                        <a href="{{ route('counseling.index') }}" class="btn btn-light font-weight-bold" style="border-radius: 8px; font-size: 13px;">
                            <i class="mdi mdi-arrow-left mr-1"></i> Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ===== INFO BANNER ===== --}}
<div class="row mb-4">
    <div class="col-12">
        <div style="background: #e8f0fe; border-radius: 10px; padding: 12px 16px; display: flex; align-items: center; gap: 10px; border: 1px solid #c5d5f8;">
            <i class="mdi mdi-information-outline" style="font-size: 18px; color: #4e73df; flex-shrink: 0;"></i>
            <p class="mb-0" style="font-size: 13px; color: #4e73df;">
                Pilih salah satu guru di bawah untuk memulai sesi konseling. Pesan kamu akan langsung masuk ke chat.
            </p>
        </div>
    </div>
</div>

{{-- ===== INSTRUCTOR GRID ===== --}}
<div class="row">
    @forelse($instructors as $instructor)
    <div class="col-sm-6 col-md-4 col-lg-3 mb-4">
        <div class="card border-0 shadow-sm h-100"
             style="border-radius: 14px; transition: all 0.25s cubic-bezier(.4,0,.2,1); overflow: hidden;"
             onmouseover="this.style.transform='translateY(-4px)';this.style.boxShadow='0 10px 28px rgba(78,115,223,0.15)';"
             onmouseout="this.style.transform='translateY(0)';this.style.boxShadow='';">

            {{-- Top accent bar --}}
            <div style="height: 4px; background: linear-gradient(90deg, #4e73df, #224abe);"></div>

            <div class="card-body p-4 text-center d-flex flex-column align-items-center">

                {{-- Avatar --}}
                <div style="position: relative; margin-bottom: 14px;">
                    <img src="{{ $instructor->avatar_url }}"
                         alt="{{ $instructor->name }}"
                         style="width: 76px; height: 76px; border-radius: 50%; object-fit: cover; border: 3px solid #e8f0fe; display: block;">
                    {{-- Online dot --}}
                    <div style="position: absolute; bottom: 3px; right: 3px; width: 14px; height: 14px; background: #1cc88a; border-radius: 50%; border: 2px solid #fff;"></div>
                </div>

                {{-- Name & role --}}
                <h6 class="font-weight-bold text-dark mb-1" style="font-size: 14px;">{{ $instructor->name }}</h6>
                <span style="background: #e8f0fe; color: #4e73df; border-radius: 20px; padding: 3px 10px; font-size: 11px; font-weight: 600; margin-bottom: 14px; display: inline-flex; align-items: center; gap: 4px;">
                    <i class="mdi mdi-human-male-board" style="font-size: 13px;"></i> Guru
                </span>

                {{-- Divider --}}
                <div style="width: 100%; height: 1px; background: #f0f0f3; margin-bottom: 14px;"></div>

                {{-- Info rows --}}
                <div style="width: 100%; text-align: left; margin-bottom: 16px;">
                    @if($instructor->email)
                    <div class="d-flex align-items-center mb-2" style="gap: 8px;">
                        <i class="mdi mdi-email-outline" style="font-size: 14px; color: #adb5bd; flex-shrink: 0;"></i>
                        <span style="font-size: 11px; color: #858796; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">{{ $instructor->email }}</span>
                    </div>
                    @endif
                    <div class="d-flex align-items-center" style="gap: 8px;">
                        <i class="mdi mdi-chat-outline" style="font-size: 14px; color: #adb5bd; flex-shrink: 0;"></i>
                        <span style="font-size: 11px; color: #858796;">Siap menerima konsultasi</span>
                    </div>
                </div>

                {{-- CTA button --}}
                <form action="{{ route('counseling.start', $instructor->id) }}" method="POST" style="width: 100%; margin: 0;">
                    @csrf
                    <button type="submit"
                            style="width: 100%; padding: 10px; border-radius: 8px; border: none; background: linear-gradient(135deg, #4e73df, #224abe); color: #fff; font-size: 13px; font-weight: 600; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 6px; transition: opacity 0.2s; box-shadow: 0 4px 12px rgba(78,115,223,.28);"
                            onmouseover="this.style.opacity='0.9';"
                            onmouseout="this.style.opacity='1';">
                        <i class="mdi mdi-message-plus-outline" style="font-size: 16px;"></i> Mulai Konsultasi
                    </button>
                </form>

            </div>
        </div>
    </div>

    @empty
    {{-- Empty state --}}
    <div class="col-12">
        <div class="card border-0 shadow-sm text-center py-5" style="border-radius: 14px;">
            <div class="card-body">
                <div style="background: #f0f0f3; border-radius: 50%; width: 80px; height: 80px; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px;">
                    <i class="mdi mdi-account-off-outline" style="font-size: 40px; color: #c4c6d0;"></i>
                </div>
                <h5 class="font-weight-bold text-dark mb-1">Belum Ada Guru Tersedia</h5>
                <p class="text-muted mb-3" style="font-size: 13px; max-width: 300px; margin: 0 auto 16px;">Saat ini belum ada guru yang tersedia untuk konseling. Coba lagi nanti.</p>
                <a href="{{ route('counseling.index') }}" class="btn btn-outline-primary" style="border-radius: 8px; font-size: 13px; font-weight: 600;">
                    <i class="mdi mdi-arrow-left mr-1"></i> Kembali
                </a>
            </div>
        </div>
    </div>
    @endforelse
</div>

@endsection