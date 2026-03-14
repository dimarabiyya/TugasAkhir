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
                                <i class="mdi mdi-chat-outline text-white" style="font-size: 26px;"></i>
                            </div>
                            <div>
                                <h4 class="font-weight-bold text-white mb-0">Chat Konseling</h4>
                                <p class="text-white-50 mb-0" style="font-size: 14px;">
                                    Percakapan dengan
                                    <strong class="text-white">
                                        {{ Auth::user()->hasRole('student') ? $session->instructor->name : $session->student->name }}
                                    </strong>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-xl-4 d-flex justify-content-xl-end">
                        <a href="{{ route('counseling.index') }}" class="btn btn-light font-weight-bold" style="border-radius: 8px; font-size: 13px;">
                            <i class="mdi mdi-arrow-left mr-1"></i> Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ===== CHAT CARD ===== --}}
<div class="row">
    <div class="col-md-12">
        <div class="card border-0 shadow-sm" style="border-radius: 12px;">

            {{-- Chat Header --}}
            <div class="card-header border-0 px-4 py-3" style="background: #f8f9fc; border-radius: 12px 12px 0 0; border-bottom: 1px solid #e3e6f0;">
                <div class="d-flex align-items-center">
                    {{-- Avatar --}}
                    <div>
                        <img src="{{ Auth::user()->hasRole('student') ? $session->instructor->avatar_url : $session->student->avatar_url }}" style="width: 42px; height: 42px; display: flex; align-items: center; border-radius: 50%;  justify-content: center; margin-right: 12px; flex-shrink: 0;" srcset="">
                    </div>
                    <div>
                        <p class="mb-0 font-weight-bold text-dark" style="font-size: 15px;">
                            {{ Auth::user()->hasRole('student') ? $session->instructor->name : $session->student->name }}
                        </p>
                        <div class="d-flex align-items-center">
                            <span style="width: 8px; height: 8px; background: #1cc88a; border-radius: 50%; display: inline-block; margin-right: 5px;"></span>
                            <small class="text-muted" style="font-size: 12px;">Sesi Konseling Aktif</small>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Chat Messages --}}
            <div class="card-body p-0">
                <div id="chat-container"
                     style="height: 430px; overflow-y: auto; padding: 24px; background: #fdfdff;">

                    @forelse($messages as $msg)
                        @php $isMine = $msg->sender_id == Auth::id(); @endphp

                        <div class="d-flex mb-4 {{ $isMine ? 'justify-content-end' : 'justify-content-start' }}">

                            {{-- Avatar (other person) --}}
                            @unless($isMine)
                            <div>
                                <img src="{{ Auth::user()->hasRole('student') ? $session->instructor->avatar_url : $session->student->avatar_url }}" style="width: 34px; height: 34px; background: #e8f0fe; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-right: 10px; flex-shrink: 0; align-self: flex-end;">
                            </div>
                            @endunless

                            <div style="max-width: 65%;">
                                {{-- Sender name + time --}}
                                <p class="mb-1 {{ $isMine ? 'text-right' : 'text-left' }}" style="font-size: 11px; color: #adb5bd;">
                                    {{ $msg->sender->name }} &bull; {{ $msg->created_at->format('H:i') }}
                                </p>
                                {{-- Bubble --}}
                                <div style="
                                    display: inline-block;
                                    padding: 10px 16px;
                                    border-radius: {{ $isMine ? '18px 18px 4px 18px' : '18px 18px 18px 4px' }};
                                    font-size: 14px;
                                    line-height: 1.5;
                                    word-break: break-word;
                                    {{ $isMine
                                        ? 'background: linear-gradient(135deg, #4e73df, #224abe); color: #fff; box-shadow: 0 2px 8px rgba(78,115,223,0.3);'
                                        : 'background: #f0f2f8; color: #3d3d3d; box-shadow: 0 2px 6px rgba(0,0,0,0.05);'
                                    }}
                                ">
                                    {{ $msg->message }}
                                </div>
                            </div>

                            {{-- Avatar (my side) --}}
                            @if($isMine)
                            <div style="width: 34px; height: 34px; background: linear-gradient(135deg, #4e73df, #224abe); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-left: 10px; flex-shrink: 0; align-self: flex-end;">
                                <i class="mdi mdi-account text-white" style="font-size: 18px;"></i>
                            </div>
                            @endif

                        </div>
                    @empty
                        <div class="d-flex flex-column align-items-center justify-content-center h-100" style="min-height: 300px;">
                            <div style="background: #f0f2f8; border-radius: 50%; width: 80px; height: 80px; display: flex; align-items: center; justify-content: center; margin-bottom: 16px;">
                                <i class="mdi mdi-chat-sleep-outline" style="font-size: 40px; color: #c4c6d0;"></i>
                            </div>
                            <p class="font-weight-bold text-dark mb-1">Belum ada percakapan</p>
                            <p class="text-muted mb-0" style="font-size: 13px;">Mulai chat dengan mengirimkan pesan pertama.</p>
                        </div>
                    @endforelse
                </div>
            </div>

            {{-- Chat Input --}}
            <div class="card-footer border-0 px-4 py-3" style="background: #f8f9fc; border-radius: 0 0 12px 12px; border-top: 1px solid #e3e6f0;">
                <form action="{{ route('counseling.message.store', $session->id) }}" method="POST">
                    @csrf
                    <div class="d-flex align-items-end" style="gap: 10px;">
                        <textarea name="message"
                                  id="message-input"
                                  class="form-control"
                                  rows="1"
                                  placeholder="Tulis pesan Anda di sini..."
                                  required
                                  style="border-radius: 10px; padding: 10px 14px; font-size: 14px; border-color: #d1d3e2; resize: none; flex: 1; min-height: 44px; max-height: 120px; overflow-y: auto; line-height: 1.5;"></textarea>
                        <button type="submit"
                                class="btn btn-primary d-flex align-items-center justify-content-center"
                                style="border-radius: 10px; width: 46px; height: 44px; flex-shrink: 0; padding: 0;">
                            <i class="mdi mdi-send" style="font-size: 18px;"></i>
                        </button>
                    </div>
                    <small class="text-muted mt-2 d-block" style="font-size: 11px;">
                        <i class="mdi mdi-information-outline mr-1"></i>Tekan tombol kirim untuk mengirim pesan
                    </small>
                </form>
            </div>

        </div>
    </div>
</div>

@push('styles')
<style>
    #chat-container {
        scroll-behavior: smooth;
    }

    #chat-container::-webkit-scrollbar {
        width: 4px;
    }

    #chat-container::-webkit-scrollbar-track {
        background: transparent;
    }

    #chat-container::-webkit-scrollbar-thumb {
        background: #d1d3e2;
        border-radius: 4px;
    }

    #message-input:focus {
        border-color: #4e73df !important;
        box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.15) !important;
    }

    .btn-primary:hover {
        background: #2e59d9;
        transform: scale(1.04);
        transition: all 0.15s ease;
    }
</style>
@endpush

@push('scripts')
<script>
    // Auto-scroll ke bawah saat halaman load
    const chatContainer = document.getElementById('chat-container');
    chatContainer.scrollTop = chatContainer.scrollHeight;

    // Auto-resize textarea
    const textarea = document.getElementById('message-input');
    textarea.addEventListener('input', function () {
        this.style.height = 'auto';
        this.style.height = Math.min(this.scrollHeight, 120) + 'px';
    });

    // Kirim dengan Ctrl+Enter
    textarea.addEventListener('keydown', function (e) {
        if (e.ctrlKey && e.key === 'Enter') {
            this.closest('form').submit();
        }
    });
</script>
@endpush

@endsection