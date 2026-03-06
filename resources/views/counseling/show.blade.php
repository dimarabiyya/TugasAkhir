@extends('layouts.skydash')

@section('content')
<div class="row">
    <div class="col-md-10 mb-4">
        <h3 class="font-weight-bold">Chat Konseling</h3>
        <p class="text-muted">Lihat percakapan dan keluhan terkait sesi konseling ini.</p>
    </div>
    <div class="col-md-2 mb-4 text-end">
        <a href="{{ route('counseling.index') }}" class="btn btn-light">
            <i class="ti-arrow-left"></i> Kembali
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Konseling dengan {{ Auth::user()->hasRole('student') ? $session->instructor->name : $session->student->name }}</h4>
                
                <div class="chat-container mb-4" style="height: 400px; overflow-y: auto; border: 1px solid #f3f3f3; padding: 20px; border-radius: 10px;">
                    @forelse($messages as $msg)
                        <div class="mb-3 {{ $msg->sender_id == Auth::id() ? 'text-right' : 'text-left' }}">
                            <p class="small mb-1 text-muted">{{ $msg->sender->name }} • {{ $msg->created_at->format('H:i') }}</p>
                            <div class="p-2 d-inline-block rounded {{ $msg->sender_id == Auth::id() ? 'bg-primary text-white' : 'bg-light text-dark' }}" style="max-width: 70%;">
                                {{ $msg->message }}
                            </div>
                        </div>
                    @empty
                        <p class="text-center text-muted">Belum ada percakapan. Silahkan mulai chat.</p>
                    @endforelse
                </div>

                <form action="{{ route('counseling.message.store', $session->id) }}" method="POST">
                    @csrf
                    <div class="input-group">
                        <textarea name="message" class="form-control" rows="2" placeholder="Tulis keluhan atau jawaban Anda di sini..." required></textarea>
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="submit">
                                <i class="ti-location-arrow"></i> Kirim
                            </button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection