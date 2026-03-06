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
                        <h3 class="font-weight-bold">Perpustakaan Digital</h3>
                        <p class="text-muted mb-0">Jelajahi koleksi lengkap e-Book pembelajaran berkualitas tinggi</p>
                    </div>
                </div>
            </div>
            <div class="col-12 col-xl-4">
                <div class="d-flex justify-content-end">
                    @if(Auth::user()->hasRole('admin'))
                        <a href="{{ route('ebooks.create') }}" class="btn btn-primary text-white d-flex align-items-center gap-2" style="border: none;">
                            <i class="icon-plus"></i> Tambah e-Book
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 grid-margin">
                <div class="card-body">
                    <div class="filter-card">
                        <form action="{{ route('ebooks.index') }}" method="GET" id="searchForm">
                            <div class="row align-items-end g-3">

                                <div class="col-md-10">
                                    <label class="filter-label" for="search">Cari E-book</label>
                                    <div class="search-input-wrapper">
                                    <i class="mdi mdi-magnify search-icon"></i>
                                    <input type="text" class="form-control" name="search" id="search"
                                        placeholder="Ketik kata kunci..." value="{{ request('search') }}" autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="d-flex gap-2">
                                        <button type="submit" class="btn btn-sm btn-primary flex-grow-1">
                                            <i class="mdi mdi-magnify"></i> Cari
                                        </button>
                                        <a href="{{ route('ebooks.index') }}" class="btn-reset" title="Reset">
                                            <i class="mdi mdi-refresh"></i>
                                        </a>
                                    </div>
                                </div>

                            </div>
                        </form>
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
                                @php
                                    // Cek apakah di database sudah ada kata 'covers/' atau belum
                                    $imagePath = Str::contains($ebook->cover_image, 'covers/') 
                                                ? $ebook->cover_image 
                                                : 'covers/' . $ebook->cover_image;
                                @endphp
                                <img src="{{ asset('storage/' . $imagePath) }}" 
                                    alt="{{ $ebook->title }}" 
                                    class="w-100 h-100 object-fit-cover" 
                                    loading="lazy">
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

@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap4.min.css">
<style>
  .filter-card {
    font-family: 'Plus Jakarta Sans', sans-serif;
    background: #ffffff;
    border-radius: 16px;
    padding: 20px 24px;
    box-shadow: 0 2px 12px rgba(0,0,0,0.06), 0 1px 3px rgba(0,0,0,0.04);
    border: 1px solid #f0f0f0;
  }
  .filter-label {
    font-size: 11px; font-weight: 600; letter-spacing: 0.6px;
    text-transform: uppercase; color: #9ca3af; margin-bottom: 6px; display: block;
  }
  .filter-card .form-control {
    font-size: 14px; font-weight: 500; color: #111827;
    background: #f9fafb; border: 1.5px solid #e5e7eb;
    border-radius: 10px; padding: 9px 14px; height: auto;
    transition: all 0.2s; box-shadow: none;
  }
  .filter-card .form-control:focus {
    background: #fff; border-color: #6366f1;
    box-shadow: 0 0 0 3px rgba(99,102,241,0.12);
  }
  .search-input-wrapper { position: relative; }
  .search-icon { position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #9ca3af; font-size: 17px; pointer-events: none; }
  .search-input-wrapper .form-control { padding-left: 38px; }
    select.form-control { appearance: none; background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%239ca3af' d='M6 8L1 3h10z'/%3E%3C/svg%3E"); background-repeat: no-repeat; background-position: right 14px center; padding-right: 36px; cursor: pointer; }
  .btn-search { font-size: 13px; font-weight: 600; background: linear-gradient(135deg,#6366f1,#4f46e5); color: #fff; border: none; border-radius: 10px; padding: 9px 20px; display: flex; align-items: center; gap: 6px; box-shadow: 0 2px 8px rgba(99,102,241,0.3); transition: all 0.2s; cursor: pointer; }
  .btn-search:hover { background: linear-gradient(135deg,#4f46e5,#4338ca); transform: translateY(-1px); box-shadow: 0 4px 14px rgba(99,102,241,0.4); color:#fff; }
  .btn-reset { font-size: 13px; font-weight: 600; background: #f3f4f6; color: #6b7280; border: 1.5px solid #e5e7eb; border-radius: 10px; padding: 9px 14px; display: flex; align-items: center; gap: 6px; transition: all 0.2s; cursor: pointer; text-decoration: none; }
  .btn-reset:hover { background: #e5e7eb; color: #374151; }

</style>
@endpush

@push('script')
<script>
    (function($) {
        'use strict';
        $(document).ready(function() {
            // Suppress DataTables warnings and alerts
            $.fn.dataTable.ext.errMode = 'none';
            
            // Override DataTables alert function to suppress popup warnings
            if (typeof $.fn.dataTable.ext.sErrMode !== 'undefined') {
                $.fn.dataTable.ext.sErrMode = 'none';
            }
            
            // Suppress alert dialogs
            var originalAlert = window.alert;
            window.alert = function() {
                var message = arguments[0];
                if (typeof message === 'string' && message.indexOf('DataTables warning') !== -1) {
                    console.warn('DataTables warning suppressed:', message);
                    return;
                }
                return originalAlert.apply(window, arguments);
            };
            
            // Destroy existing DataTable instance if any
            if ($.fn.DataTable.isDataTable('#coursesTable')) {
                $('#coursesTable').DataTable().destroy();
            }

            // Verify column count before initialization
            var $table = $('#coursesTable');
            var headerCols = $table.find('thead tr').children().length;
            var firstRowCols = $table.find('tbody tr:first').children().length;
            
            // Ensure all rows have correct column count
            $table.find('tbody tr').each(function() {
                var $row = $(this);
                var cols = $row.children('td').length;
                if (cols !== headerCols && cols !== 1) { // Allow colspan=1 for empty state
                    console.warn('Row has incorrect column count:', cols, 'Expected:', headerCols);
                }
            });

            var table = $('#coursesTable').DataTable({
                responsive: {
                    details: {
                        type: 'column',
                        target: 'tr'
                    }
                },
                pageLength: 10,
                lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
                order: [[0, 'asc']],
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Cari kursus...",
                    lengthMenu: "Tampilkan _MENU_ entri",
                    info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ courses",
                    infoEmpty: "Tidak ada kursus tersedia",
                    infoFiltered: "(difilter dari _MAX_ total kursus)",
                    paginate: {
                        first: "Pertama",
                        last: "Terakhir",
                        next: "Selanjutnya",
                        previous: "Sebelumnya"
                    },
                    emptyTable: "Tidak ada mata pelajaran ditemukan"
                },
                columnDefs: [
                    {
                        targets: 0, // Course column
                        responsivePriority: 1
                    },
                    {
                        targets: 1, // Instructor column
                        responsivePriority: 2
                    },
                    {
                        targets: 7, // Actions column (last column)
                        orderable: false,
                        searchable: false,
                        responsivePriority: 10000
                    },
                    {
                        targets: [2, 3, 4, 5, 6], // Level, Status, Duration, Modules, Price
                        responsivePriority: 3
                    }
                ],
                autoWidth: false
            });
            
            // Handle DataTables errors silently
            table.on('error.dt', function(e, settings, techNote, message) {
                console.log('DataTables error suppressed:', message);
                return false;
            });
            
            $('#coursesTable').each(function() {
                var datatable = $(this);
                var search_input = datatable.closest('.dataTables_wrapper').find('div[id$=_filter] input');
                search_input.attr('placeholder', 'Cari kursus...');
                search_input.removeClass('form-control-sm');
                var length_sel = datatable.closest('.dataTables_wrapper').find('div[id$=_length] select');
                length_sel.removeClass('form-control-sm');
            });
        });
    })(jQuery);
</script>
@endpush
@endsection