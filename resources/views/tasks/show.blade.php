@extends('layouts.skydash')

@section('content')
<div class="content-wrapper">
    <div class="row">
        {{-- Detail Tugas --}}
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h3 class="font-weight-bold text-primary">{{ $task->title }}</h3>
                    <p class="text-muted">Materi: {{ $task->lesson->title }}</p>
                    <hr>
                    <h5>Instruksi:</h5>
                    <p>{!! nl2br(e($task->instructions)) !!}</p>
                </div>
            </div>
        </div>

        {{-- Sisi Kanan: Status/Form Pengumpulan --}}
        <div class="col-md-4">
            {{-- JIKA USER ADALAH STUDENT --}}
            @if(!auth()->user()->hasAnyRole(['admin', 'instructor']))
                <div class="card shadow-sm border-info">
                    <div class="card-body">
                        <h4 class="card-title">Kumpulkan Tugas</h4>
                        
                        <form action="{{ route('tasks.submit', $task->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label>Tipe Pengumpulan</label>
                                <select name="submission_type" id="sub_type" class="form-control">
                                    <option value="file">Upload File</option>
                                    <option value="link">Kirim Link (G-Drive/URL)</option>
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
                                <textarea name="notes" class="form-control" rows="3" placeholder="Tambahkan pesan..."></textarea>
                            </div>

                            <button type="submit" class="btn btn-primary btn-block">Kirim Sekarang</button>
                        </form>
                    </div>
                </div>
            @endif
        </div>
    </div>

    {{-- JIKA USER ADALAH ADMIN/INSTRUCTOR --}}
    @if(auth()->user()->hasAnyRole(['admin', 'instructor']))
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Daftar Pengumpulan Siswa</h4>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Nama Siswa</th>
                                    <th>Tipe</th>
                                    <th>Konten Tugas</th>
                                    <th>Waktu Kirim</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($task->submissions as $sub)
                                <tr>
                                    <td>{{ $sub->student->name }}</td>
                                    <td><span class="badge badge-outline-info text-dark">{{ ucfirst($sub->submission_type) }}</span></td>
                                    <td>
                                        @if($sub->submission_type == 'file')
                                            <a href="{{ asset('storage/' . $sub->file_path) }}" target="_blank" class="btn btn-sm btn-info">
                                                Download File
                                            </a>
                                        @else
                                            <a href="{{ $sub->link_url }}" target="_blank" class="text-primary font-weight-bold">Buka Link</a>
                                        @endif
                                    </td>
                                    <td>{{ $sub->created_at->diffForHumans() }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted">Belum ada siswa yang mengumpulkan.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>

<script>
    // Toggle input File vs Link
    document.getElementById('sub_type').addEventListener('change', function() {
        if(this.value === 'file') {
            document.getElementById('file_input_group').style.display = 'block';
            document.getElementById('link_input_group').style.display = 'none';
        } else {
            document.getElementById('file_input_group').style.display = 'none';
            document.getElementById('link_input_group').style.display = 'block';
        }
    });
</script>
@endsection