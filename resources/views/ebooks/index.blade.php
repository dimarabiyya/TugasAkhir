@extends('layouts.skydash')

@section('content')

{{-- ===== PAGE HEADER ===== --}}
<div class="row mb-4">
    <div class="col-md-12">
        <div class="card border-0 shadow-sm" style="background: linear-gradient(135deg, #4e73df 0%, #224abe 100%); border-radius: 12px;">
            <div class="card-body py-4 px-4">
                <div class="row align-items-center">
                    <div class="col-12 col-xl-8 mb-3 mb-xl-0">
                        <div class="d-flex align-items-center">
                            <div style="background: rgba(255,255,255,0.2); border-radius: 10px; width: 48px; height: 48px; display: flex; align-items: center; justify-content: center; margin-right: 14px; flex-shrink: 0;">
                                <i class="mdi mdi-book-open-page-variant text-white" style="font-size: 26px;"></i>
                            </div>
                            <div>
                                <h4 class="font-weight-bold text-white mb-0">Perpustakaan Digital</h4>
                                <p class="text-white-50 mb-0" style="font-size: 14px;">Jelajahi koleksi lengkap e-Book pembelajaran berkualitas tinggi</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-xl-4 d-flex justify-content-xl-end">
                        @if(Auth::user()->hasRole('admin'))
                        <a href="{{ route('ebooks.create') }}" class="btn font-weight-bold"
                           style="background: #fff; color: #4e73df; border-radius: 8px; font-size: 13px; border: none; white-space: nowrap;">
                            <i class="mdi mdi-plus mr-1"></i> Tambah E-books
                        </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ===== SUCCESS ALERT ===== --}}
@if(session('success'))
<div class="row mb-3">
    <div class="col-md-12">
        <div class="alert border-0 shadow-sm d-flex align-items-center" role="alert"
             style="background: #e3f9e5; border-radius: 10px; padding: 14px 18px;">
            <div style="background: #1cc88a; border-radius: 50%; width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; margin-right: 12px; flex-shrink: 0;">
                <i class="mdi mdi-check text-white" style="font-size: 16px;"></i>
            </div>
            <span style="color: #0f6c46; font-size: 14px; font-weight: 500;">{{ session('success') }}</span>
            <button type="button" class="close ml-auto" data-dismiss="alert" style="color: #0f6c46; opacity: 0.6;">
                <i class="mdi mdi-close" style="font-size: 18px;"></i>
            </button>
        </div>
    </div>
</div>
@endif

{{-- ===== SEARCH ===== --}}
<div class="row mb-4">
    <div class="col-md-12">
        <div class="card border-0 shadow-sm" style="border-radius: 12px;">
            <div class="card-body p-4">
                <form action="{{ route('ebooks.index') }}" method="GET" id="searchForm">
                    <div class="row align-items-end">
                        <div class="col-md-10 mb-3 mb-md-0">
                            <label class="text-dark font-weight-600 mb-1" style="font-size: 13px;">
                                <i class="mdi mdi-magnify mr-1 text-muted"></i> Cari e-Book
                            </label>
                            <div style="position: relative;">
                                <i class="mdi mdi-magnify" style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #adb5bd; font-size: 18px; pointer-events: none;"></i>
                                <input type="text"
                                       class="form-control"
                                       name="search"
                                       id="search"
                                       placeholder="Ketik judul, penulis, atau kata kunci..."
                                       value="{{ request('search') }}"
                                       autocomplete="off"
                                       style="border-radius: 8px; padding: 10px 14px 10px 38px; font-size: 14px; border-color: #d1d3e2;">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="d-flex" style="gap: 8px;">
                                <button type="submit"
                                        class="btn btn-primary flex-grow-1"
                                        style="border-radius: 8px; font-size: 13px; font-weight: 600; padding: 10px 0;">
                                    <i class="mdi mdi-magnify mr-1"></i> Cari
                                </button>
                                <a href="{{ route('ebooks.index') }}"
                                   title="Reset pencarian"
                                   style="background: #f0f0f3; color: #858796; border-radius: 8px; width: 42px; height: 42px; display: flex; align-items: center; justify-content: center; text-decoration: none; flex-shrink: 0; transition: all 0.2s;"
                                   onmouseover="this.style.background='#e3e6f0';this.style.color='#5a5c69';"
                                   onmouseout="this.style.background='#f0f0f3';this.style.color='#858796';">
                                    <i class="mdi mdi-refresh" style="font-size: 18px;"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- ===== EBOOK GRID ===== --}}
@if($ebooks->count() > 0)

{{-- Results info --}}
<div class="d-flex align-items-center mb-3" style="gap: 8px;">
    <div style="background: #e8f0fe; border-radius: 6px; padding: 4px 10px; display: inline-flex; align-items: center; gap: 6px;">
        <i class="mdi mdi-bookshelf" style="color: #4e73df; font-size: 15px;"></i>
        <span style="font-size: 13px; color: #4e73df; font-weight: 600;">{{ $ebooks->total() ?? $ebooks->count() }} e-Book</span>
    </div>
    @if(request('search'))
    <span class="text-muted" style="font-size: 13px;">hasil pencarian untuk <strong>"{{ request('search') }}"</strong></span>
    @endif
</div>

<div class="row">
    @foreach($ebooks as $ebook)
    <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
        <div class="card h-100 border-0 shadow-sm" style="border-radius: 12px; overflow: hidden; transition: box-shadow 0.2s ease, transform 0.2s ease;"
             onmouseover="this.style.boxShadow='0 8px 24px rgba(0,0,0,0.12)';this.style.transform='translateY(-3px)';"
             onmouseout="this.style.boxShadow='';this.style.transform='translateY(0)';">

            {{-- Cover --}}
            <div class="position-relative d-flex align-items-center justify-content-center overflow-hidden"
                 style="aspect-ratio: 3/4; background: white">
                @if($ebook->cover_image)
                    @php
                        $imagePath = Str::contains($ebook->cover_image, 'covers/')
                            ? $ebook->cover_image
                            : 'covers/' . $ebook->cover_image;
                    @endphp
                    <img src="{{ asset('storage/' . $imagePath) }}"
                         alt="{{ $ebook->title }}"
                         class="w-100 h-100"
                         style="object-fit: cover;"
                         loading="lazy">
                @else
                    <i class="mdi mdi-book-open-variant text-white" style="font-size: 64px; opacity: 0.4;"></i>
                @endif

                {{-- PDF Badge --}}
                <span style="position: absolute; top: 10px; right: 10px; background: #e74a3b; color: white; border-radius: 6px; padding: 3px 8px; font-size: 11px; font-weight: 700; display: flex; align-items: center; gap: 4px;">
                    <i class="mdi mdi-file-pdf-box" style="font-size: 13px;"></i> PDF
                </span>
            </div>

            {{-- Card Body --}}
            <div class="card-body d-flex flex-column p-3">
                <h6 class="font-weight-bold text-dark mb-2" style="font-size: 14px; line-height: 1.4; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                    {{ $ebook->title }}
                </h6>

                <div class="mb-2 flex-grow-1">
                    <div class="d-flex align-items-center mb-1" style="gap: 6px;">
                        <i class="mdi mdi-account-outline" style="color: #4e73df; font-size: 13px; flex-shrink: 0;"></i>
                        <span class="text-muted" style="font-size: 12px;">{{ $ebook->author ?? 'Penulis tidak ada' }}</span>
                    </div>
                    <div class="d-flex align-items-center mb-2" style="gap: 6px;">
                        <i class="mdi mdi-calendar-outline" style="color: #f6c23e; font-size: 13px; flex-shrink: 0;"></i>
                        <span class="text-muted" style="font-size: 12px;">{{ $ebook->publication_year ?? 'Tahun tidak ada' }}</span>
                    </div>
                    @if($ebook->description)
                    <p class="text-muted mb-0" style="font-size: 12px; line-height: 1.4; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                        {{ $ebook->description }}
                    </p>
                    @endif
                </div>

                {{-- Actions --}}
                <div class="d-flex mt-2 pt-2" style="gap: 8px; border-top: 1px solid #f0f0f3;">
                    <a href="{{ route('ebooks.download', $ebook->id) }}"
                       class="btn btn-primary btn-sm flex-grow-1 d-flex align-items-center justify-content-center"
                       style="border-radius: 8px; font-size: 13px; font-weight: 600; gap: 5px; padding: 8px 0;">
                        <i class="mdi mdi-download" style="font-size: 15px;"></i> Download
                    </a>

                    @if(Auth::user()->hasRole('admin'))
                    <form action="{{ route('ebooks.destroy', $ebook->id) }}" method="POST"
                          onsubmit="return confirm('Hapus buku \'{{ addslashes($ebook->title) }}\' secara permanen?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                title="Hapus e-Book"
                                style="background: #fde8e8; color: #e74a3b; border-radius: 8px; width: 34px; height: 34px; display: flex; align-items: center; justify-content: center; border: none; cursor: pointer; transition: all 0.2s;"
                                onmouseover="this.style.background='#e74a3b';this.style.color='#fff';"
                                onmouseout="this.style.background='#fde8e8';this.style.color='#e74a3b';">
                            <i class="mdi mdi-delete-outline" style="font-size: 16px;"></i>
                        </button>
                    </form>
                    @endif
                </div>
            </div>

        </div>
    </div>
    @endforeach
</div>

{{-- Pagination --}}
@if($ebooks->hasPages())
<div class="d-flex justify-content-center mt-2 mb-4">
    {{ $ebooks->withQueryString()->links() }}
</div>
@endif

@else
{{-- ===== EMPTY STATE ===== --}}
<div class="card border-0 shadow-sm" style="border-radius: 12px;">
    <div class="card-body text-center py-5">
        <div style="background: #f0f0f3; border-radius: 50%; width: 100px; height: 100px; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px;">
            <i class="mdi mdi-bookshelf" style="font-size: 52px; color: #c4c6d0;"></i>
        </div>
        <h5 class="font-weight-bold text-dark mb-1">
            @if(request('search'))
                Tidak ditemukan hasil
            @else
                Belum ada e-Book
            @endif
        </h5>
        <p class="text-muted mb-4" style="font-size: 14px;">
            @if(request('search'))
                Tidak ada e-Book yang cocok dengan kata kunci <strong>"{{ request('search') }}"</strong>.
            @else
                Koleksi perpustakaan masih kosong. Mulai tambahkan e-Book baru!
            @endif
        </p>
        <div class="d-flex justify-content-center" style="gap: 10px;">
            @if(request('search'))
            <a href="{{ route('ebooks.index') }}" class="btn btn-outline-secondary" style="border-radius: 8px; font-weight: 600;">
                <i class="mdi mdi-refresh mr-1"></i> Reset Pencarian
            </a>
            @endif
            @if(Auth::user()->hasRole('admin'))
            <a href="{{ route('ebooks.create') }}" class="btn font-weight-bold"
                style="background: #fff; color: #4e73df; border-radius: 8px; font-size: 13px; border: none; white-space: nowrap;">
                <i class="mdi mdi-plus mr-1"></i> Tambah E-books
            </a>
            @endif
        </div>
    </div>
</div>
@endif

@push('styles')
<style>
    .form-control:focus {
        border-color: #4e73df !important;
        box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.15) !important;
    }
</style>
@endpush

@push('scripts')
<script>
    $(document).ready(function () {
        let timeout = null;
        $('#search').on('keyup', function () {
            clearTimeout(timeout);
            timeout = setTimeout(function () {
                const val = $('#search').val();
                if (val.length >= 3 || val.length === 0) {
                    $('#searchForm').submit();
                }
            }, 500);
        });
    });
</script>
@endpush

@endsection