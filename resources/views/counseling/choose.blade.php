@extends('layouts.skydash')

@section('content')
<div class="row">
    <div class="col-md-12 mb-4">
        <h3 class="font-weight-bold">Pilih Instruktur Konseling</h3>
    </div>
    @foreach($instructors as $instructor)
    <div class="col-md-3 grid-margin stretch-card">
        <div class="card">
            <div class="card-body text-center">
                <img src="{{ $instructor->avatar_url }}" class="img-lg rounded-circle mb-3" alt="profile">
                <h4>{{ $instructor->name }}</h4>
                <p class="text-muted">Instruktur Pelatih</p>
                <form action="{{ route('counseling.start', $instructor->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-primary btn-sm mt-3">Mulai Konsultasi</button>
                </form>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endsection