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
                                <i class="mdi mdi-comment-alert-outline text-white" style="font-size: 26px;"></i>
                            </div>
                            <div>
                                <h4 class="font-weight-bold text-white mb-0">Kelola Aduan Siswa</h4>
                                <p class="text-white-50 mb-0" style="font-size: 13px;">Setujui, tolak, dan kelola aduan siswa</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ===== STAT CARDS ===== --}}
<div class="row mb-4">
    {{-- Total --}}
    <div class="col-6 col-md-3 mb-3 mb-md-0">
        <div class="card border-0 shadow-sm" style="border-radius: 12px;">
            <div class="card-body p-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <p class="text-muted mb-1" style="font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px;">Total Aduan</p>
                        <h3 class="font-weight-bold text-dark mb-0">{{ $stats['total'] }}</h3>
                    </div>
                    <div style="background: #e8f0fe; border-radius: 10px; width: 44px; height: 44px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                        <i class="mdi mdi-comment-multiple-outline" style="font-size: 22px; color: #4e73df;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- Disetujui --}}
    <div class="col-6 col-md-3 mb-3 mb-md-0">
        <div class="card border-0 shadow-sm" style="border-radius: 12px;">
            <div class="card-body p-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <p class="text-muted mb-1" style="font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px;">Disetujui</p>
                        <h3 class="font-weight-bold mb-0" style="color: #1cc88a;">{{ $stats['approved'] }}</h3>
                    </div>
                    <div style="background: #e3f9e5; border-radius: 10px; width: 44px; height: 44px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                        <i class="mdi mdi-check-circle-outline" style="font-size: 22px; color: #1cc88a;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- Menunggu --}}
    <div class="col-6 col-md-3">
        <div class="card border-0 shadow-sm" style="border-radius: 12px;">
            <div class="card-body p-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <p class="text-muted mb-1" style="font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px;">Menunggu</p>
                        <h3 class="font-weight-bold mb-0" style="color: #f6c23e;">{{ $stats['pending'] }}</h3>
                    </div>
                    <div style="background: #fff3e8; border-radius: 10px; width: 44px; height: 44px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                        <i class="mdi mdi-clock-outline" style="font-size: 22px; color: #f6c23e;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- Unggulan --}}
    <div class="col-6 col-md-3">
        <div class="card border-0 shadow-sm" style="border-radius: 12px;">
            <div class="card-body p-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <p class="text-muted mb-1" style="font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px;">Unggulan</p>
                        <h3 class="font-weight-bold mb-0" style="color: #17a2b8;">{{ $stats['featured'] }}</h3>
                    </div>
                    <div style="background: #e0f7fa; border-radius: 10px; width: 44px; height: 44px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                        <i class="mdi mdi-star-outline" style="font-size: 22px; color: #17a2b8;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ===== FILTER CARD ===== --}}
<div class="row mb-4">
    <div class="col-md-12">
        <div class="card border-0 shadow-sm" style="border-radius: 12px;">
            <div class="card-body p-4">
                <form action="{{ route('testimonials.manage') }}" method="GET" id="searchForm">
                    <div class="row align-items-end" style="gap: 0;">

                        {{-- Search --}}
                        <div class="col-12 col-md-4 mb-3 mb-md-0">
                            <label class="mb-2" style="font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #9ca3af;">Cari Aduan</label>
                            <div style="position: relative;">
                                <div style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); pointer-events: none;">
                                    <i class="mdi mdi-magnify" style="font-size: 17px; color: #adb5bd;"></i>
                                </div>
                                <input type="text"
                                       name="search"
                                       class="form-control"
                                       placeholder="Cari nama, email, atau isi aduan..."
                                       value="{{ request('search') }}"
                                       style="border-radius: 8px; border-color: #d1d3e2; font-size: 13px; height: 42px; padding-left: 38px;"
                                       onfocus="this.style.borderColor='#4e73df'; this.style.boxShadow='0 0 0 3px rgba(78,115,223,0.12)';"
                                       onblur="this.style.borderColor='#d1d3e2'; this.style.boxShadow='none';">
                            </div>
                        </div>

                        {{-- Status --}}
                        <div class="col-12 col-md-3 mb-3 mb-md-0">
                            <label class="mb-2" style="font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #9ca3af;">Status</label>
                            <div style="position: relative;">
                                <select name="status"
                                        class="form-control"
                                        style="border-radius: 8px; border-color: #d1d3e2; font-size: 13px; height: 42px; appearance: none; -webkit-appearance: none; padding-right: 36px; cursor: pointer;"
                                        onfocus="this.style.borderColor='#4e73df'; this.style.boxShadow='0 0 0 3px rgba(78,115,223,0.12)';"
                                        onblur="this.style.borderColor='#d1d3e2'; this.style.boxShadow='none';">
                                    <option value="">Semua Status</option>
                                    <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Disetujui</option>
                                    <option value="pending"  {{ request('status') === 'pending'  ? 'selected' : '' }}>Menunggu</option>
                                </select>
                                <div style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); pointer-events: none;">
                                    <i class="mdi mdi-chevron-down" style="font-size: 17px; color: #adb5bd;"></i>
                                </div>
                            </div>
                        </div>

                        {{-- Tampilkan --}}
                        <div class="col-12 col-md-3 mb-3 mb-md-0">
                            <label class="mb-2" style="font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #9ca3af;">Tampilkan</label>
                            <div style="position: relative;">
                                <select name="featured"
                                        class="form-control"
                                        style="border-radius: 8px; border-color: #d1d3e2; font-size: 13px; height: 42px; appearance: none; -webkit-appearance: none; padding-right: 36px; cursor: pointer;"
                                        onfocus="this.style.borderColor='#4e73df'; this.style.boxShadow='0 0 0 3px rgba(78,115,223,0.12)';"
                                        onblur="this.style.borderColor='#d1d3e2'; this.style.boxShadow='none';">
                                    <option value="">Semua Aduan</option>
                                    <option value="1" {{ request('featured') === '1' ? 'selected' : '' }}>Hanya Unggulan</option>
                                    <option value="0" {{ request('featured') === '0' ? 'selected' : '' }}>Bukan Unggulan</option>
                                </select>
                                <div style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); pointer-events: none;">
                                    <i class="mdi mdi-chevron-down" style="font-size: 17px; color: #adb5bd;"></i>
                                </div>
                            </div>
                        </div>

                        {{-- Buttons --}}
                        <div class="col-12 col-md-2">
                            <div class="d-flex" style="gap: 6px;">
                                <button type="submit"
                                        class="btn flex-fill"
                                        style="background: linear-gradient(135deg, #4e73df, #224abe); color: #fff; border-radius: 8px; font-weight: 600; font-size: 13px; height: 42px; border: none; box-shadow: 0 3px 10px rgba(78,115,223,0.25);">
                                    <i class="mdi mdi-magnify mr-1"></i> Cari
                                </button>
                                <a href="{{ route('testimonials.manage') }}"
                                   class="btn"
                                   title="Reset filter"
                                   style="background: #f4f6fb; color: #6b7280; border-radius: 8px; font-weight: 600; font-size: 13px; height: 42px; border: 1px solid #e3e6f0; padding: 0 12px; display: flex; align-items: center; justify-content: center; transition: all 0.2s;"
                                   onmouseover="this.style.background='#e3e6f0';"
                                   onmouseout="this.style.background='#f4f6fb';">
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

{{-- ===== TABLE CARD ===== --}}
<div class="row">
    <div class="col-md-12">
        <div class="card border-0 shadow-sm" style="border-radius: 12px;">
            <div class="card-body p-0">

                {{-- Card Header --}}
                <div class="d-flex align-items-center justify-content-between px-4 py-3" style="border-bottom: 1px solid #f0f0f3;">
                    <div class="d-flex align-items-center">
                        <div style="background: #e8f0fe; border-radius: 8px; width: 34px; height: 34px; display: flex; align-items: center; justify-content: center; margin-right: 10px;">
                            <i class="mdi mdi-comment-text-multiple-outline" style="font-size: 18px; color: #4e73df;"></i>
                        </div>
                        <div>
                            <h5 class="mb-0 font-weight-bold text-dark">Daftar Aduan</h5>
                            <small class="text-muted">{{ $testimonials->total() }} aduan ditemukan</small>
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table mb-0" style="border-collapse: separate; border-spacing: 0;">
                        <thead>
                            <tr style="background: #f8f9fc;">
                                <th style="padding: 12px 20px; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #858796; border-bottom: 1px solid #eaecf4; border-top: none; white-space: nowrap;">Siswa</th>
                                <th style="padding: 12px 16px; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #858796; border-bottom: 1px solid #eaecf4; border-top: none;">Mata Pelajaran</th>
                                <th style="padding: 12px 16px; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #858796; border-bottom: 1px solid #eaecf4; border-top: none;">Isi Aduan</th>
                                <th style="padding: 12px 16px; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #858796; border-bottom: 1px solid #eaecf4; border-top: none; white-space: nowrap;">Penilaian</th>
                                <th style="padding: 12px 16px; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #858796; border-bottom: 1px solid #eaecf4; border-top: none;">Status</th>
                                <th style="padding: 12px 16px; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #858796; border-bottom: 1px solid #eaecf4; border-top: none; white-space: nowrap;">Tanggal</th>
                                <th style="padding: 12px 16px; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #858796; border-bottom: 1px solid #eaecf4; border-top: none; text-align: center;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($testimonials as $t)
                            <tr style="transition: background 0.15s ease;"
                                onmouseover="this.style.background='#f8f9fc';"
                                onmouseout="this.style.background='white';">

                                {{-- Siswa --}}
                                <td style="padding: 14px 20px; border-bottom: 1px solid #f0f0f3; vertical-align: middle;">
                                    <div class="d-flex align-items-center" style="gap: 10px;">
                                        @if($t->user->avatar ?? false)
                                            <img src="{{ asset('storage/' . $t->user->avatar) }}"
                                                 alt="{{ $t->user->name }}"
                                                 style="width: 36px; height: 36px; border-radius: 50%; object-fit: cover; border: 2px solid #e8f0fe; flex-shrink: 0;">
                                        @else
                                            <img src="{{ $t->user->avatar_url }}"
                                                 alt="{{ $t->user->name }}"
                                                 style="width: 36px; height: 36px; border-radius: 50%; object-fit: cover; border: 2px solid #e8f0fe; flex-shrink: 0;"
                                                 onerror="this.src='{{ asset('images/landing/testimonials_user.jpg') }}'">
                                        @endif
                                        <div>
                                            <p class="mb-0 font-weight-bold text-dark" style="font-size: 13px;">{{ $t->user->name }}</p>
                                            <small class="text-muted">{{ $t->user->email }}</small>
                                        </div>
                                    </div>
                                </td>

                                {{-- Mata Pelajaran --}}
                                <td style="padding: 14px 16px; border-bottom: 1px solid #f0f0f3; vertical-align: middle;">
                                    @if($t->course)
                                        <span style="background: #e0f7fa; color: #17a2b8; border-radius: 6px; padding: 3px 10px; font-size: 11px; font-weight: 600; white-space: nowrap;">
                                            {{ Str::limit($t->course->title, 25) }}
                                        </span>
                                    @else
                                        <span class="text-muted" style="font-size: 12px;">Umum</span>
                                    @endif
                                </td>

                                {{-- Isi Aduan --}}
                                <td style="padding: 14px 16px; border-bottom: 1px solid #f0f0f3; vertical-align: middle; max-width: 260px;">
                                    <p class="mb-0 text-dark" style="font-size: 12.5px; line-height: 1.5; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                                        "{{ Str::limit($t->testimonial_text, 90) }}"
                                    </p>
                                </td>

                                {{-- Penilaian --}}
                                <td style="padding: 14px 16px; border-bottom: 1px solid #f0f0f3; vertical-align: middle; white-space: nowrap;">
                                    @if($t->rating)
                                        <div class="d-flex align-items-center" style="gap: 2px;">
                                            @for($i = 1; $i <= 5; $i++)
                                                <i class="mdi mdi-star{{ $i <= $t->rating ? '' : '-outline' }}"
                                                   style="font-size: 15px; color: {{ $i <= $t->rating ? '#f6c23e' : '#d1d3e2' }};"></i>
                                            @endfor
                                            <small class="text-muted ml-1">{{ $t->rating }}/5</small>
                                        </div>
                                    @else
                                        <span class="text-muted" style="font-size: 12px;">—</span>
                                    @endif
                                </td>

                                {{-- Status --}}
                                <td style="padding: 14px 16px; border-bottom: 1px solid #f0f0f3; vertical-align: middle;">
                                    @if($t->is_approved)
                                        <span style="background: #e3f9e5; color: #1cc88a; border-radius: 6px; padding: 4px 10px; font-size: 11px; font-weight: 700;">
                                            <i class="mdi mdi-check-circle mr-1"></i>Disetujui
                                        </span>
                                    @else
                                        <span style="background: #fff3e8; color: #f6c23e; border-radius: 6px; padding: 4px 10px; font-size: 11px; font-weight: 700;">
                                            <i class="mdi mdi-clock-outline mr-1"></i>Menunggu
                                        </span>
                                    @endif
                                    @if($t->is_featured ?? false)
                                    <span style="background: #e0f7fa; color: #17a2b8; border-radius: 6px; padding: 4px 10px; font-size: 11px; font-weight: 700; display: inline-block; margin-top: 3px;">
                                        <i class="mdi mdi-star mr-1"></i>Unggulan
                                    </span>
                                    @endif
                                </td>

                                {{-- Tanggal --}}
                                <td style="padding: 14px 16px; border-bottom: 1px solid #f0f0f3; vertical-align: middle; white-space: nowrap;">
                                    <p class="mb-0 text-dark" style="font-size: 12.5px; font-weight: 500;">
                                        {{ $t->created_at->format('d M Y') }}
                                    </p>
                                    <small class="text-muted">{{ $t->created_at->format('H:i') }}</small>
                                </td>

                                {{-- Aksi --}}
                                <td style="padding: 14px 16px; border-bottom: 1px solid #f0f0f3; vertical-align: middle; text-align: center;">
                                    <div class="d-flex align-items-center justify-content-center" style="gap: 5px; flex-wrap: wrap;">

                                        {{-- Approve / Reject --}}
                                        @if(!$t->is_approved)
                                        <form action="{{ route('testimonials.approve', $t) }}" method="POST" class="d-inline m-0">
                                            @csrf @method('PATCH')
                                            <button type="submit" title="Setujui"
                                                    style="background: #e3f9e5; color: #1cc88a; border: none; border-radius: 8px; width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: all 0.2s;"
                                                    onmouseover="this.style.background='#1cc88a';this.style.color='#fff';"
                                                    onmouseout="this.style.background='#e3f9e5';this.style.color='#1cc88a';">
                                                <i class="mdi mdi-check" style="font-size: 16px;"></i>
                                            </button>
                                        </form>
                                        @else
                                        <form action="{{ route('testimonials.reject', $t) }}" method="POST" class="d-inline m-0">
                                            @csrf @method('PATCH')
                                            <button type="submit" title="Tolak"
                                                    style="background: #fff3e8; color: #f6c23e; border: none; border-radius: 8px; width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: all 0.2s;"
                                                    onmouseover="this.style.background='#f6c23e';this.style.color='#fff';"
                                                    onmouseout="this.style.background='#fff3e8';this.style.color='#f6c23e';">
                                                <i class="mdi mdi-close" style="font-size: 16px;"></i>
                                            </button>
                                        </form>
                                        @endif

                                        {{-- Toggle Unggulan --}}
                                        @if($t->is_approved)
                                        <form action="{{ route('testimonials.toggle-featured', $t) }}" method="POST" class="d-inline m-0">
                                            @csrf @method('PATCH')
                                            <button type="submit"
                                                    title="{{ ($t->is_featured ?? false) ? 'Hapus dari Unggulan' : 'Tandai Unggulan' }}"
                                                    style="background: {{ ($t->is_featured ?? false) ? '#e0f7fa' : '#f4f6fb' }}; color: {{ ($t->is_featured ?? false) ? '#17a2b8' : '#9ca3af' }}; border: none; border-radius: 8px; width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: all 0.2s;"
                                                    onmouseover="this.style.background='#17a2b8';this.style.color='#fff';"
                                                    onmouseout="this.style.background='{{ ($t->is_featured ?? false) ? '#e0f7fa' : '#f4f6fb' }}';this.style.color='{{ ($t->is_featured ?? false) ? '#17a2b8' : '#9ca3af' }}';">
                                                <i class="mdi mdi-star{{ ($t->is_featured ?? false) ? '' : '-outline' }}" style="font-size: 16px;"></i>
                                            </button>
                                        </form>
                                        @endif

                                        {{-- View --}}
                                        <a href="{{ route('testimonials.index', $t) }}"
                                           target="_blank"
                                           title="Lihat"
                                           style="background: #e8f0fe; color: #4e73df; border-radius: 8px; width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; text-decoration: none; transition: all 0.2s;"
                                           onmouseover="this.style.background='#4e73df';this.style.color='#fff';"
                                           onmouseout="this.style.background='#e8f0fe';this.style.color='#4e73df';">
                                            <i class="mdi mdi-eye" style="font-size: 16px;"></i>
                                        </a>

                                        {{-- Delete --}}
                                        <form action="{{ route('testimonials.destroy', $t) }}" method="POST" class="d-inline m-0"
                                              onsubmit="confirmDelete(event, 'Aduan siswa ini akan dihapus permanen.');">
                                            @csrf @method('DELETE')
                                            <button type="submit" title="Hapus"
                                                    style="background: #fde8e8; color: #e74a3b; border: none; border-radius: 8px; width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: all 0.2s;"
                                                    onmouseover="this.style.background='#e74a3b';this.style.color='#fff';"
                                                    onmouseout="this.style.background='#fde8e8';this.style.color='#e74a3b';">
                                                <i class="mdi mdi-delete" style="font-size: 16px;"></i>
                                            </button>
                                        </form>

                                    </div>
                                </td>

                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" style="padding: 48px 20px; text-align: center;">
                                    <div style="background: #f0f0f3; border-radius: 50%; width: 72px; height: 72px; display: flex; align-items: center; justify-content: center; margin: 0 auto 14px;">
                                        <i class="mdi mdi-comment-remove-outline" style="font-size: 36px; color: #c4c6d0;"></i>
                                    </div>
                                    <h5 class="font-weight-bold text-dark mb-1">Tidak Ada Aduan Ditemukan</h5>
                                    <p class="text-muted mb-0" style="font-size: 13px;">Coba sesuaikan filter atau kata kunci pencarian.</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                @if($testimonials->hasPages())
                <div class="px-4 py-3" style="border-top: 1px solid #f0f0f3; background: #fafbff; border-radius: 0 0 12px 12px;">
                    <div class="d-flex align-items-center justify-content-between flex-wrap" style="gap: 8px;">
                        <p class="text-muted mb-0" style="font-size: 12px;">
                            Menampilkan {{ $testimonials->firstItem() }}–{{ $testimonials->lastItem() }} dari {{ $testimonials->total() }} aduan
                        </p>
                        {{ $testimonials->withQueryString()->links() }}
                    </div>
                </div>
                @endif

            </div>
        </div>
    </div>
</div>

@endsection