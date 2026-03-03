@extends('layouts.skydash')

@section('content')
<div class="row">
    <div class="col-md-12 grid-margin">
        <div class="row">
            <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                @if(auth()->check() && auth()->user()->hasAnyRole(['admin', 'instructor']))
                    <h3 class="font-weight-bold">Deskripsi Tugas</h3>
                    <p class="text-muted">Kelola semua deskripsi tugas</p>
                @else
                    <h3 class="font-weight-bold">Deskripsi Tugas</h3>
                    <p class="text-muted">Uji kemampuan Anda dengan tugas ini</p>
                @endif
            </div>
        </div>
    </div>

    <div class="row">
        {{-- SISI KIRI: DETAIL TUGAS --}}
        <div class="col-md-8 grid-margin stretch-card">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h3 class="font-weight-bold text-primary">{{ $task->title }}</h3>
                    <p class="text-muted">Materi: {{ optional($task->lesson)->title }}</p>
                    <hr>
                    <h5 class="font-weight-bold">Instruksi:</h5>
                    <p class="text-justify">{!! nl2br(e($task->instructions)) !!}</p>
                </div>
            </div>
        </div>

        {{-- SISI KANAN: FORM SUBMIT (UNTUK SISWA) --}}
        <div class="col-md-4 grid-margin stretch-card">
            @if(!auth()->user()->hasAnyRole(['admin', 'instructor']))
                <div class="card shadow-sm border-info">
                    <div class="card-body">
                        <h4 class="card-title">Status Pengumpulan</h4>
                        
                        {{-- Tampilkan Nilai Jika Sudah Dinilai --}}
                        @php $mySub = $task->submissions->where('user_id', auth()->id())->first(); @endphp
                        @if($mySub && $mySub->grade)
                            <div class="alert alert-success text-center">
                                <p class="mb-0">Nilai Anda:</p>
                                <h2 class="font-weight-bold">{{ $mySub->grade->score }}</h2>
                                <small>{{ $mySub->grade->feedback }}</small>
                            </div>
                        @endif

                        <form action="{{ route('tasks.submit', $task->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label>Tipe Pengumpulan</label>
                                <select name="submission_type" id="sub_type" class="form-control">
                                    <option value="file">Upload File</option>
                                    <option value="link">Kirim Link</option>
                                </select>
                            </div>

                            <div id="file_input_group">
                                <div class="form-group">
                                    <label>Pilih File (PDF/JPG/PNG)</label>
                                    <input type="file" name="file" class="form-control">
                                </div>
                            </div>

                            <div id="link_input_group" style="display: none;">
                                <div class="form-group">
                                    <label>Masukkan URL</label>
                                    <input type="url" name="link_url" class="form-control" placeholder="https://...">
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Catatan</label>
                                <textarea name="notes" class="form-control" rows="3">{{ $mySub->notes ?? '' }}</textarea>
                            </div>

                            <button type="submit" class="btn btn-primary btn-block">
                                {{ $mySub ? 'Update Jawaban' : 'Kirim Jawaban' }}
                            </button>
                        </form>
                    </div>
                </div>
            @endif
        </div>
    </div>

    {{-- BAGIAN ADMIN & GURU: TABEL PENGUMPULAN --}}
    @if(auth()->user()->hasAnyRole(['admin', 'instructor']))
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Daftar Pengumpulan Siswa</h4>
                    <div class="table-responsive">
                        <table class="table table-hover table-striped">
                            <thead>
                                <tr>
                                    <th>Nama Siswa</th>
                                    <th>Tipe</th>
                                    <th>Konten</th>
                                    <th>Status Nilai</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($task->submissions as $sub)
                                <tr>
                                    <td>{{ $sub->student->name }}</td>
                                    <td>
                                        <span class="badge {{ $sub->submission_type == 'file' ? 'badge-info' : 'badge-dark' }}">
                                            {{ ucfirst($sub->submission_type) }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($sub->submission_type == 'file')
                                            <a href="{{ asset('storage/' . $sub->file_path) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                                <i class="mdi mdi-eye"></i>  Lihat File
                                            </a>
                                        @else
                                            <a href="{{ $sub->link_url }}" target="_blank" class="btn btn-sm btn-outline-info">
                                                <i class="mdi mdi-eye"></i> Buka Link
                                            </a>
                                        @endif
                                    </td>
                                    <td>
                                        @if($sub->grade)
                                            <div class="badge badge-success">Nilai: {{ $sub->grade->score }}</div>
                                        @else
                                            <div class="badge badge-warning">Belum Dinilai</div>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            {{-- Tombol Buka Modal --}}
                                            <button type="button" class="btn btn-primary btn-sm mr-2" data-bs-toggle="modal" data-bs-target="#gradeModal{{ $sub->id }}">
                                                <i class="ti-pencil"></i> {{ $sub->grade ? 'Edit Nilai' : 'Beri Nilai' }}
                                            </button>

                                            {{-- Tombol Hapus Nilai --}}
                                            @if($sub->grade)
                                            <form action="{{ route('tasks.grade.destroy', $sub->grade->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus nilai ini?')">
                                                    <i class="ti-trash"></i> Hapus
                                                </button>
                                            </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted">Belum ada siswa yang mengumpulkan tugas.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- MODAL AREA (Looping terpisah agar ID modal unik) --}}
    @foreach($task->submissions as $sub)
    <div class="modal fade" id="gradeModal{{ $sub->id }}" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title font-weight-bold">Penilaian: {{ $sub->student->name }}</h5>
                </div>
                <form action="{{ route('tasks.grade', $sub->id) }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group text-center">
                            @if($sub->submission_type == 'file')
                                <p class="small text-muted">File: {{ $sub->original_file_name }}</p>
                            @else
                                <p class="small text-muted">Link: <a href="{{ $sub->link_url }}" target="_blank">{{ $sub->link_url }}</a></p>
                            @endif
                        </div>
                        <div class="form-group">
                            <label>Skor (0-100)</label>
                            <input type="number" name="score" class="form-control form-control-lg text-center" 
                                value="{{ $sub->grade->score ?? '' }}" required min="0" max="100">
                        </div>
                        <div class="form-group">
                            <label>Feedback / Catatan</label>
                            <textarea name="feedback" class="form-control" rows="4" placeholder="Tulis masukan untuk siswa...">{{ $sub->grade->feedback ?? '' }}</textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Simpan Nilai</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endforeach
    @endif
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('#sub_type').on('change', function() {
            if($(this).val() === 'file') {
                $('#file_input_group').show();
                $('#link_input_group').hide();
            } else {
                $('#file_input_group').hide();
                $('#link_input_group').show();
            }
        });
    });
</script>
@endsection