@extends('layouts.skydash')

@section('content')

<style>
    .gradient-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }

    .gradient-primary-dark {
        background: linear-gradient(135deg, #5568d3 0%, #6b3b8c 100%);
    }

    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>

<!-- Header Section -->
<div class="row">
    @if(session('success'))
        <div class="col-md-12 mb-4">
            <div class="alert alert-success alert-dismissible fade show d-flex align-items-center bg-success bg-opacity-10 border border-success" role="alert">
                <i class="icon-check-circle me-3 text-success"></i>
                <span class="text-success">{{ session('success') }}</span>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        </div>
    @endif

    <div class="col-md-12 grid-margin">
        <div class="row align-items-center">
            <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                <div class="d-flex align-items-center">
                    <div>
                        <h2 class="mb-2 text-dark" style="font-size: 28px;">Perpustakaan Digital</h2>
                        <p class="text-muted mb-0">Jelajahi koleksi lengkap e-Book pembelajaran berkualitas tinggi</p>
                    </div>
                </div>
            </div>
            <div class="col-12 col-xl-4">
                <div class="d-flex justify-content-end">
                    @if(Auth::user()->hasRole('admin'))
                        <a href="{{ route('ebooks.create') }}" class="btn text-white fw-bold d-flex align-items-center gap-2 gradient-primary" style="border: none;">
                            <i class="icon-plus"></i> Tambah e-Book
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Main Content -->
<div class="py-0">
    <div class="container-fluid px-0">
        @if($ebooks->count() > 0)
            <!-- Products Grid -->
            <div class="row g-4 mb-5">
                @foreach($ebooks as $ebook)
                <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                    <div class="card h-100 border-0 shadow-sm overflow-hidden transition-all" style="transition: all 0.3s ease;">
                        <!-- Cover Image -->
                        <div class="position-relative bg-gradient gradient-primary d-flex align-items-center justify-content-center overflow-hidden" style="aspect-ratio: 3/4; cursor: pointer;">
                            @if($ebook->cover_image)
                                <img src="{{ asset('storage/' . $ebook->cover_image) }}" alt="{{ $ebook->title }}" class="w-100 h-100 object-fit-cover" loading="lazy" style="transition: transform 0.3s ease;">
                            @else
                                <i class="icon-book text-white" style="font-size: 64px; opacity: 0.5;"></i>
                            @endif
                            <span class="badge bg-danger position-absolute top-0 end-0 m-3 d-flex align-items-center gap-2">
                                <i class="icon-file-pdf"></i> PDF
                            </span>
                        </div>

                        <!-- Card Body -->
                        <div class="card-body d-flex flex-column flex-grow-1 p-4">
                            <h5 class="card-title fw-bold text-dark mb-3 line-clamp-2" style="font-size: 15px;">
                                {{ $ebook->title }}
                            </h5>

                            <!-- Metadata -->
                            <div class="mb-3 flex-grow-1">
                                <div class="small mb-2 text-muted d-flex align-items-center gap-2">
                                    <i class="icon-user" style="color: #667eea; font-size: 13px;"></i>
                                    <span>{{ $ebook->author ?? 'Penulis tidak ada' }}</span>
                                </div>
                                <div class="small mb-3 text-muted d-flex align-items-center gap-2">
                                    <i class="icon-calendar" style="color: #d97706; font-size: 13px;"></i>
                                    <span>{{ $ebook->publication_year ?? 'Tahun tidak ada' }}</span>
                                </div>
                                @if($ebook->description)
                                    <div class="small text-secondary" style="font-size: 12px; line-height: 1.4;">
                                        {{ Str::limit($ebook->description, 45) }}
                                    </div>
                                @endif
                            </div>

                            <!-- Actions -->
                            <div class="d-flex gap-2 mt-auto pt-3 border-top">
                                <a href="{{ route('ebooks.download', $ebook->id) }}" class="btn btn-sm flex-grow-1 text-white fw-bold d-flex align-items-center justify-content-center gap-2 gradient-primary" style="border: none; font-size: 13px; transition: all 0.3s ease;">
                                    <i class="icon-download"></i> Download
                                </a>

                                @if(Auth::user()->hasRole('admin'))
                                    <form action="{{ route('ebooks.destroy', $ebook->id) }}" method="POST" onsubmit="return confirm('Hapus buku ini secara permanen?');" class="d-contents">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm bg-light border border-danger-subtle text-danger fw-bold d-flex align-items-center justify-content-center" style="font-size: 13px; min-width: 44px; transition: all 0.3s ease; cursor: pointer;" title="Hapus buku">
                                            <i class="icon-trash-2"></i> Hapus
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Pagination -->
            @if($ebooks->hasPages())
                <div class="d-flex justify-content-center mt-5">
                    {{ $ebooks->links() }}
                </div>
            @endif

        @else
            <!-- Empty State -->
            <div class="text-center py-5 my-5">
                <div class="mb-4" style="font-size: 80px; color: #d1d5db; opacity: 0.6;">
                    <i class="icon-inbox"></i>
                </div>
                <h4 class="text-dark fw-bold mb-2">Belum Ada e-Book</h4>
                <p class="text-muted mb-4">Koleksi e-Book masih kosong. Mulai tambahkan konten baru sekarang!</p>
                @if(Auth::user()->hasRole('admin'))
                    <a href="{{ route('ebooks.create') }}" class="btn text-white fw-bold d-inline-flex align-items-center gap-2 gradient-primary" style="border: none;">
                        <i class="icon-plus"></i> Tambah e-Book Pertama
                    </a>
                @endif
            </div>
        @endif
    </div>
</div>

@endsection