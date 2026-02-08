@extends('layouts.skydash')

@section('content')
<div class="content-wrapper">
    <div class="row">
        <div class="col-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Edit Data Guru</h4>
                    <form class="forms-sample" action="{{ route('instructors.update', $instructor->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="name">Nama Lengkap</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $instructor->name) }}" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Alamat Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $instructor->email) }}" required>
                        </div>
                        <hr>
                        <p class="text-muted small">Kosongkan password jika tidak ingin mengubahnya.</p>
                        <div class="form-group">
                            <label for="password">Password Baru (Opsional)</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Password Baru">
                        </div>
                        <div class="form-group">
                            <label for="password_confirmation">Konfirmasi Password Baru</label>
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Ulangi Password Baru">
                        </div>
                        <button type="submit" class="btn btn-primary mr-2">Update Data</button>
                        <a href="{{ route('instructors.index') }}" class="btn btn-light">Batal</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection