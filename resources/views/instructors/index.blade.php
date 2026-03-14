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
                                <i class="mdi mdi-human-male-board text-white" style="font-size: 26px;"></i>
                            </div>
                            <div>
                                <h4 class="font-weight-bold text-white mb-0">Manajemen Guru</h4>
                                <p class="text-white-50 mb-0" style="font-size: 13px;">Daftar dan kelola akun guru pengajar</p>
                            </div>
                        </div>
                    </div>
                    @if(auth()->check() && auth()->user()->hasAnyRole(['admin']))
                    <div class="col-12 col-xl-4 d-flex justify-content-xl-end">
                        <a href="{{ route('instructors.create') }}"
                           class="btn font-weight-bold"
                           style="background: #fff; color: #4e73df; border-radius: 8px; font-size: 13px; border: none;">
                            <i class="mdi mdi-plus mr-1"></i> Tambah Guru
                        </a>
                    </div>
                    @endif
                </div>
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
                            <h5 class="mb-0 font-weight-bold text-dark">Daftar Guru</h5>
                            <small class="text-muted">{{ $instructors->total() }} guru terdaftar</small>
                        </div>
                    </div>
                </div>

                @if($instructors->count())
                <div class="table-responsive">
                    <table class="table mb-0" style="border-collapse: separate; border-spacing: 0;">
                        <thead>
                            <tr style="background: #f8f9fc;">
                                <th style="padding: 12px 20px; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #858796; border-bottom: 1px solid #eaecf4; border-top: none;">#</th>
                                <th style="padding: 12px 16px; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #858796; border-bottom: 1px solid #eaecf4; border-top: none;">Nama</th>
                                <th style="padding: 12px 16px; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #858796; border-bottom: 1px solid #eaecf4; border-top: none;">Email</th>
                                <th style="padding: 12px 16px; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #858796; border-bottom: 1px solid #eaecf4; border-top: none; white-space: nowrap;">Bergabung</th>
                                <th style="padding: 12px 16px; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #858796; border-bottom: 1px solid #eaecf4; border-top: none; text-align: center;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($instructors as $index => $instructor)
                            <tr style="transition: background 0.15s ease;"
                                onmouseover="this.style.background='#f8f9fc';"
                                onmouseout="this.style.background='white';">

                                {{-- No --}}
                                <td style="padding: 14px 20px; border-bottom: 1px solid #f0f0f3; vertical-align: middle;">
                                    <span style="background: #e8f0fe; color: #4e73df; border-radius: 6px; padding: 2px 9px; font-size: 12px; font-weight: 700;">
                                        {{ $instructors->firstItem() + $index }}
                                    </span>
                                </td>

                                {{-- Nama --}}
                                <td style="padding: 14px 16px; border-bottom: 1px solid #f0f0f3; vertical-align: middle;">
                                    <div class="d-flex align-items-center" style="gap: 10px;">
                                        <div >
                                            <img src=" {{ $instructor->avatar_url }} " style="width: 36px; height: 36px; border-radius: 50%; object-fit: cover; border: 2px solid #e8f0fe; flex-shrink: 0;">
                                           
                                        </div>
                                        <p class="mb-0 font-weight-bold text-dark" style="font-size: 13.5px;">{{ $instructor->name }}</p>
                                    </div>
                                </td>

                                {{-- Email --}}
                                <td style="padding: 14px 16px; border-bottom: 1px solid #f0f0f3; vertical-align: middle;">
                                    <div class="d-flex align-items-center" style="gap: 6px;">
                                        <i class="mdi mdi-email-outline" style="font-size: 15px; color: #adb5bd;"></i>
                                        <span style="font-size: 13px; color: #5a5c69;">{{ $instructor->email }}</span>
                                    </div>
                                </td>

                                {{-- Bergabung --}}
                                <td style="padding: 14px 16px; border-bottom: 1px solid #f0f0f3; vertical-align: middle; white-space: nowrap;">
                                    <div class="d-flex align-items-center" style="gap: 6px;">
                                        <i class="mdi mdi-calendar-outline" style="font-size: 15px; color: #adb5bd;"></i>
                                        <span style="font-size: 13px; color: #5a5c69;">{{ $instructor->created_at->format('d M Y') }}</span>
                                    </div>
                                </td>

                                {{-- Aksi --}}
                                <td style="padding: 14px 16px; border-bottom: 1px solid #f0f0f3; vertical-align: middle; text-align: center;">
                                    <div class="d-flex align-items-center justify-content-center" style="gap: 6px;">
                                        <a href="{{ route('instructors.edit', $instructor->id) }}"
                                           title="Edit"
                                           style="background: #e8f0fe; color: #4e73df; border-radius: 8px; width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; text-decoration: none; transition: all 0.2s;"
                                           onmouseover="this.style.background='#4e73df';this.style.color='#fff';"
                                           onmouseout="this.style.background='#e8f0fe';this.style.color='#4e73df';">
                                            <i class="mdi mdi-pencil" style="font-size: 15px;"></i>
                                        </a>
                                        <form action="{{ route('instructors.destroy', $instructor->id) }}" method="POST" class="d-inline m-0"
                                              onsubmit="confirmDelete(event, 'Data guru ini akan dihapus permanen.');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    title="Hapus"
                                                    style="background: #fde8e8; color: #e74a3b; border: none; border-radius: 8px; width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: all 0.2s;"
                                                    onmouseover="this.style.background='#e74a3b';this.style.color='#fff';"
                                                    onmouseout="this.style.background='#fde8e8';this.style.color='#e74a3b';">
                                                <i class="mdi mdi-delete" style="font-size: 15px;"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>

                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                @if($instructors->hasPages())
                <div class="px-4 py-3" style="border-top: 1px solid #f0f0f3; background: #fafbff; border-radius: 0 0 12px 12px;">
                    <div class="d-flex align-items-center justify-content-between flex-wrap" style="gap: 8px;">
                        <p class="text-muted mb-0" style="font-size: 12px;">
                            <i class="mdi mdi-information-outline mr-1 text-primary"></i>
                            Menampilkan {{ $instructors->firstItem() }}–{{ $instructors->lastItem() }} dari {{ $instructors->total() }} guru
                        </p>
                        {{ $instructors->links() }}
                    </div>
                </div>
                @endif

                @else
                {{-- Empty State --}}
                <div class="text-center py-5">
                    <div style="background: #f0f0f3; border-radius: 50%; width: 80px; height: 80px; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px;">
                        <i class="mdi mdi-human-male-board" style="font-size: 40px; color: #c4c6d0;"></i>
                    </div>
                    <h5 class="font-weight-bold text-dark mb-1">Belum Ada Data Guru</h5>
                    <p class="text-muted mb-4" style="font-size: 14px;">Tambahkan guru pertama untuk memulai</p>
                    @if(auth()->check() && auth()->user()->hasAnyRole(['admin']))
                    <a href="{{ route('instructors.create') }}"
                       class="btn btn-primary"
                       style="border-radius: 8px; font-weight: 600; padding: 10px 24px;">
                        <i class="mdi mdi-plus mr-1"></i> Tambah Guru Pertama
                    </a>
                    @endif
                </div>
                @endif

            </div>
        </div>
    </div>
</div>

@endsection