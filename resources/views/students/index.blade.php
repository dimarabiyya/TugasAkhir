@extends('layouts.skydash')

@section('content')

{{-- ===== PAGE HEADER ===== --}}
<div class="row mb-4">
    <div class="col-md-12">
        <div class="card border-0 shadow-sm" style="background: linear-gradient(135deg, #4e73df 0%, #224abe 100%); border-radius: 12px;">
            <div class="card-body py-4 px-4">
                <div class="row align-items-center">
                    <div class="col-12 col-xl-7 mb-3 mb-xl-0">
                        <div class="d-flex align-items-center">
                            <div style="background: rgba(255,255,255,0.2); border-radius: 10px; width: 48px; height: 48px; display: flex; align-items: center; justify-content: center; margin-right: 14px; flex-shrink: 0;">
                                <i class="mdi mdi-account-school-outline text-white" style="font-size: 26px;"></i>
                            </div>
                            <div>
                                <h4 class="font-weight-bold text-white mb-0">Manajemen Siswa</h4>
                                <p class="text-white-50 mb-0" style="font-size: 13px;">Kelola akun siswa dan kemajuan pembelajaran mereka</p>
                            </div>
                        </div>
                    </div>
                    @if(auth()->user()->hasRole('admin'))
                    <div class="col-12 col-xl-5 d-flex justify-content-xl-end flex-wrap" style="gap: 8px;">
                        {{-- Import Excel --}}
                        <form action="{{ route('students.import') }}" method="POST" enctype="multipart/form-data"
                              class="d-flex align-items-center" style="gap: 6px;">
                            @csrf
                            <input type="file" name="file" accept=".xlsx,.xls,.csv" required
                                   style="background: rgba(255,255,255,0.15); border: 1px solid rgba(255,255,255,0.3); border-radius: 8px; color: #fff; font-size: 12px; padding: 10px 10px ; max-width: 96px; height:5vh">
                            <button type="submit"   
                                    class="btn font-weight-bold"
                                    style="background: rgba(255,255,255,0.15); color: #fff; border-radius: 8px; font-size: 13px; border: 1px solid rgba(255,255,255,0.3); white-space: nowrap;">
                                <i class="mdi mdi-file-excel mr-1"></i> Import
                            </button>
                        </form>
                        <a href="{{ route('students.create') }}"
                           class="btn font-weight-bold"
                           style="background: #fff; color: #4e73df; border-radius: 8px; font-size: 13px; border: none; white-space: nowrap;">
                            <i class="mdi mdi-plus mr-1"></i> Tambah Siswa
                        </a>
                    </div>
                    @endif
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
                <form method="GET" action="{{ route('students.index') }}" id="searchbar">
                    <div class="row align-items-end" style="gap: 0;">

                        {{-- Search --}}
                        <div class="col-12 col-md-4 mb-3 mb-md-0">
                            <label class="mb-2" style="font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #9ca3af;">Cari Siswa</label>
                            <div style="position: relative;">
                                <div style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); pointer-events: none;">
                                    <i class="mdi mdi-magnify" style="font-size: 17px; color: #adb5bd;"></i>
                                </div>
                                <input type="text" name="search" id="search"
                                       class="form-control"
                                       placeholder="Nama, email, atau telepon..."
                                       value="{{ request('search') }}"
                                       style="border-radius: 8px; border-color: #d1d3e2; font-size: 13px; height: 42px; padding-left: 38px;"
                                       onfocus="this.style.borderColor='#4e73df'; this.style.boxShadow='0 0 0 3px rgba(78,115,223,0.12)';"
                                       onblur="this.style.borderColor='#d1d3e2'; this.style.boxShadow='none';">
                            </div>
                        </div>

                        {{-- Status Siswa --}}
                        <div class="col-12 col-md-3 mb-3 mb-md-0">
                            <label class="mb-2" style="font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #9ca3af;">Status Siswa</label>
                            <div style="position: relative;">
                                <select name="enrollment_status" id="enrollment_status" class="form-control"
                                        style="border-radius: 8px; border-color: #d1d3e2; font-size: 13px; height: 42px; appearance: none; -webkit-appearance: none; padding-right: 36px; cursor: pointer;"
                                        onfocus="this.style.borderColor='#4e73df'; this.style.boxShadow='0 0 0 3px rgba(78,115,223,0.12)';"
                                        onblur="this.style.borderColor='#d1d3e2'; this.style.boxShadow='none';">
                                    <option value="">Semua Siswa</option>
                                    <option value="enrolled"     {{ request('enrollment_status') == 'enrolled'     ? 'selected' : '' }}>Terdaftar</option>
                                    <option value="not_enrolled" {{ request('enrollment_status') == 'not_enrolled' ? 'selected' : '' }}>Tidak Terdaftar</option>
                                </select>
                                <div style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); pointer-events: none;">
                                    <i class="mdi mdi-chevron-down" style="font-size: 17px; color: #adb5bd;"></i>
                                </div>
                            </div>
                        </div>

                        {{-- Status Email --}}
                        <div class="col-12 col-md-3 mb-3 mb-md-0">
                            <label class="mb-2" style="font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #9ca3af;">Status Email</label>
                            <div style="position: relative;">
                                <select name="email_verified" id="email_verified" class="form-control"
                                        style="border-radius: 8px; border-color: #d1d3e2; font-size: 13px; height: 42px; appearance: none; -webkit-appearance: none; padding-right: 36px; cursor: pointer;"
                                        onfocus="this.style.borderColor='#4e73df'; this.style.boxShadow='0 0 0 3px rgba(78,115,223,0.12)';"
                                        onblur="this.style.borderColor='#d1d3e2'; this.style.boxShadow='none';">
                                    <option value="">Semua</option>
                                    <option value="verified"   {{ request('email_verified') == 'verified'   ? 'selected' : '' }}>Terverifikasi</option>
                                    <option value="unverified" {{ request('email_verified') == 'unverified' ? 'selected' : '' }}>Belum Terverifikasi</option>
                                </select>
                                <div style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); pointer-events: none;">
                                    <i class="mdi mdi-chevron-down" style="font-size: 17px; color: #adb5bd;"></i>
                                </div>
                            </div>
                        </div>

                        {{-- Buttons --}}
                        <div class="col-12 col-md-2">
                            <div class="d-flex" style="gap: 6px;">
                                <button type="submit" class="btn flex-fill"
                                        style="background: linear-gradient(135deg, #4e73df, #224abe); color: #fff; border-radius: 8px; font-weight: 600; font-size: 13px; height: 42px; border: none; box-shadow: 0 3px 10px rgba(78,115,223,0.25);">
                                    <i class="mdi mdi-magnify mr-1"></i> Cari
                                </button>
                                <a href="{{ route('students.index') }}"
                                   title="Reset"
                                   style="background: #f4f6fb; color: #6b7280; border-radius: 8px; font-weight: 600; font-size: 13px; height: 42px; border: 1px solid #e3e6f0; padding: 0 12px; display: flex; align-items: center; justify-content: center; text-decoration: none; transition: all 0.2s;"
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
                            <i class="mdi mdi-account-group-outline" style="font-size: 18px; color: #4e73df;"></i>
                        </div>
                        <div>
                            <h5 class="mb-0 font-weight-bold text-dark">Semua Siswa</h5>
                            <small class="text-muted">{{ $students->total() }} siswa terdaftar</small>
                        </div>
                    </div>
                </div>

                @if($students->count() > 0)
                <div class="table-responsive">
                    <table class="table mb-0" style="border-collapse: separate; border-spacing: 0;">
                        <thead>
                            <tr style="background: #f8f9fc;">
                                <th style="padding: 12px 20px; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #858796; border-bottom: 1px solid #eaecf4; border-top: none;">#</th>
                                <th style="padding: 12px 16px; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #858796; border-bottom: 1px solid #eaecf4; border-top: none;">Siswa</th>
                                <th style="padding: 12px 16px; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #858796; border-bottom: 1px solid #eaecf4; border-top: none;">NISN</th>
                                <th style="padding: 12px 16px; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #858796; border-bottom: 1px solid #eaecf4; border-top: none;">Email</th>
                                <th style="padding: 12px 16px; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #858796; border-bottom: 1px solid #eaecf4; border-top: none;">Tingkat</th>
                                <th style="padding: 12px 16px; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #858796; border-bottom: 1px solid #eaecf4; border-top: none; text-align: center;">Mapel</th>
                                <th style="padding: 12px 16px; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #858796; border-bottom: 1px solid #eaecf4; border-top: none;">Status</th>
                                <th style="padding: 12px 16px; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #858796; border-bottom: 1px solid #eaecf4; border-top: none; text-align: center;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $levelColors = ['beginner' => ['bg'=>'#e3f9e5','c'=>'#1cc88a'], 'intermediate' => ['bg'=>'#fff3e8','c'=>'#f6c23e'], 'advanced' => ['bg'=>'#fde8e8','c'=>'#e74a3b']];
                                $levelLabels = ['beginner' => 'Pemula', 'intermediate' => 'Menengah', 'advanced' => 'Lanjutan'];
                            @endphp
                            @foreach($students as $index => $student)
                            <tr style="transition: background 0.15s ease;"
                                onmouseover="this.style.background='#f8f9fc';"
                                onmouseout="this.style.background='white';">

                                {{-- No --}}
                                <td style="padding: 14px 20px; border-bottom: 1px solid #f0f0f3; vertical-align: middle;">
                                    <span style="background: #e8f0fe; color: #4e73df; border-radius: 6px; padding: 2px 9px; font-size: 12px; font-weight: 700;">
                                        {{ $students->firstItem() + $index }}
                                    </span>
                                </td>

                                {{-- Siswa --}}
                                <td style="padding: 14px 16px; border-bottom: 1px solid #f0f0f3; vertical-align: middle;">
                                    <div class="d-flex align-items-center" style="gap: 10px;">
                                        <img src="{{ $student->avatar_url }}" alt="{{ $student->name }}"
                                             style="width: 36px; height: 36px; border-radius: 50%; object-fit: cover; border: 2px solid #e8f0fe; flex-shrink: 0;">
                                        <div>
                                            <p class="mb-0 font-weight-bold text-dark" style="font-size: 13px;">{{ $student->name }}</p>
                                            <small class="text-muted">{{ $student->phone ?? '-' }}</small>
                                        </div>
                                    </div>
                                </td>

                                {{-- NISN --}}
                                <td style="padding: 14px 16px; border-bottom: 1px solid #f0f0f3; vertical-align: middle;">
                                    <span style="font-size: 13px; color: #5a5c69;">{{ $student->nisn ?? '—' }}</span>
                                </td>

                                {{-- Email --}}
                                <td style="padding: 14px 16px; border-bottom: 1px solid #f0f0f3; vertical-align: middle;">
                                    <p class="mb-0" style="font-size: 13px; color: #4e73df;">{{ $student->email }}</p>
                                    @if($student->email_verified_at)
                                        <small style="color: #1cc88a;"><i class="mdi mdi-check-circle" style="font-size: 12px;"></i> Terverifikasi</small>
                                    @else
                                        <small style="color: #f6c23e;"><i class="mdi mdi-alert-circle" style="font-size: 12px;"></i> Belum</small>
                                    @endif
                                </td>

                                {{-- Tingkat --}}
                                <td style="padding: 14px 16px; border-bottom: 1px solid #f0f0f3; vertical-align: middle;">
                                    @if($student->level)
                                        @php $lc = $levelColors[$student->level] ?? ['bg'=>'#f4f6fb','c'=>'#858796']; @endphp
                                        <span style="background: {{ $lc['bg'] }}; color: {{ $lc['c'] }}; border-radius: 6px; padding: 3px 10px; font-size: 11px; font-weight: 600;">
                                            {{ $levelLabels[$student->level] ?? ucfirst($student->level) }}
                                        </span>
                                    @else
                                        <span class="text-muted" style="font-size: 12px;">—</span>
                                    @endif
                                </td>

                                {{-- Mapel --}}
                                <td style="padding: 14px 16px; border-bottom: 1px solid #f0f0f3; vertical-align: middle; text-align: center;">
                                    <span style="background: #e0f7fa; color: #17a2b8; border-radius: 6px; padding: 3px 10px; font-size: 12px; font-weight: 700;">
                                        {{ $student->enrollments->count() }}
                                    </span>
                                    @if($student->enrollments->count() > 0)
                                    <br><small class="text-muted" style="font-size: 10px;">{{ $student->enrollments->where('completed_at', '!=', null)->count() }} selesai</small>
                                    @endif
                                </td>

                                {{-- Status --}}
                                <td style="padding: 14px 16px; border-bottom: 1px solid #f0f0f3; vertical-align: middle;">
                                    @if($student->enrollments->count() > 0)
                                        <span style="background: #e3f9e5; color: #1cc88a; border-radius: 6px; padding: 3px 10px; font-size: 11px; font-weight: 700;">
                                            <i class="mdi mdi-check-circle mr-1"></i>Aktif
                                        </span>
                                    @else
                                        <span style="background: #f4f6fb; color: #858796; border-radius: 6px; padding: 3px 10px; font-size: 11px; font-weight: 700;">
                                            <i class="mdi mdi-minus-circle mr-1"></i>Tidak Aktif
                                        </span>
                                    @endif
                                </td>

                                {{-- Aksi --}}
                                <td style="padding: 14px 16px; border-bottom: 1px solid #f0f0f3; vertical-align: middle; text-align: center;">
                                    <div class="d-flex align-items-center justify-content-center" style="gap: 5px;">
                                        <a href="{{ route('students.show', $student) }}" title="Lihat"
                                           style="background: #e8f0fe; color: #4e73df; border-radius: 8px; width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; text-decoration: none; transition: all 0.2s;"
                                           onmouseover="this.style.background='#4e73df';this.style.color='#fff';"
                                           onmouseout="this.style.background='#e8f0fe';this.style.color='#4e73df';">
                                            <i class="mdi mdi-eye" style="font-size: 15px;"></i>
                                        </a>
                                        @if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('instructor'))
                                        <a href="{{ route('students.edit', $student) }}" title="Edit"
                                           style="background: #e8f0fe; color: #4e73df; border-radius: 8px; width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; text-decoration: none; transition: all 0.2s;"
                                           onmouseover="this.style.background='#4e73df';this.style.color='#fff';"
                                           onmouseout="this.style.background='#e8f0fe';this.style.color='#4e73df';">
                                            <i class="mdi mdi-pencil" style="font-size: 15px;"></i>
                                        </a>
                                        <form action="{{ route('students.destroy', $student) }}" method="POST" class="d-inline m-0"
                                              onsubmit="confirmDelete(event, 'Data siswa ini akan dihapus permanen.');">
                                            @csrf @method('DELETE')
                                            <button type="submit" title="Hapus"
                                                    style="background: #fde8e8; color: #e74a3b; border: none; border-radius: 8px; width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: all 0.2s;"
                                                    onmouseover="this.style.background='#e74a3b';this.style.color='#fff';"
                                                    onmouseout="this.style.background='#fde8e8';this.style.color='#e74a3b';">
                                                <i class="mdi mdi-delete" style="font-size: 15px;"></i>
                                            </button>
                                        </form>
                                        @endif
                                    </div>
                                </td>

                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                @if($students->hasPages())
                <div class="px-4 py-3" style="border-top: 1px solid #f0f0f3; background: #fafbff; border-radius: 0 0 12px 12px;">
                    <div class="d-flex align-items-center justify-content-between flex-wrap" style="gap: 8px;">
                        <p class="text-muted mb-0" style="font-size: 12px;">
                            Menampilkan {{ $students->firstItem() }}–{{ $students->lastItem() }} dari {{ $students->total() }} siswa
                        </p>
                        {{ $students->withQueryString()->links() }}
                    </div>
                </div>
                @endif

                @else
                {{-- Empty State --}}
                <div class="text-center py-5">
                    <div style="background: #f0f0f3; border-radius: 50%; width: 80px; height: 80px; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px;">
                        <i class="mdi mdi-account-group-outline" style="font-size: 40px; color: #c4c6d0;"></i>
                    </div>
                    <h5 class="font-weight-bold text-dark mb-1">
                        {{ request()->hasAny(['search','enrollment_status','email_verified']) ? 'Tidak Ada Hasil Pencarian' : 'Belum Ada Siswa' }}
                    </h5>
                    <p class="text-muted mb-4" style="font-size: 14px;">
                        {{ request()->hasAny(['search','enrollment_status','email_verified']) ? 'Coba sesuaikan filter pencarian Anda.' : 'Tambahkan siswa pertama untuk memulai.' }}
                    </p>
                    @if(auth()->user()->hasRole('admin') && !request()->hasAny(['search','enrollment_status','email_verified']))
                    <a href="{{ route('students.create') }}" class="btn btn-primary" style="border-radius: 8px; font-weight: 600; padding: 10px 24px;">
                        <i class="mdi mdi-plus mr-1"></i> Tambah Siswa Pertama
                    </a>
                    @endif
                </div>
                @endif

            </div>
        </div>
    </div>
</div>

@endsection