@extends('layouts.landing')

@section('content')

{{-- ── HERO ── --}}
<section class="relative min-h-screen flex items-center pt-20 overflow-hidden" id="home"
         style="background:linear-gradient(135deg,#0f172a 0%,#1e3a5f 45%,#1e40af 100%)">

  {{-- Blobs --}}
  <div class="absolute w-96 h-96 rounded-full bg-blue-500 opacity-10 blur-3xl"
       style="top:-100px;right:-60px;animation:floatBlob 9s ease-in-out infinite"></div>
  <div class="absolute w-72 h-72 rounded-full bg-cyan-400 opacity-10 blur-3xl"
       style="bottom:0;left:-50px;animation:floatBlob 9s ease-in-out infinite 3s"></div>

  {{-- Grid overlay --}}
  <div class="absolute inset-0 pointer-events-none"
       style="background-image:linear-gradient(rgba(255,255,255,0.03) 1px,transparent 1px),linear-gradient(90deg,rgba(255,255,255,0.03) 1px,transparent 1px);background-size:44px 44px"></div>

  <div class="max-w-6xl mx-auto px-6 py-20 relative z-10 w-full">
    <div class="max-w-2xl">
      <div class="inline-flex items-center gap-2 bg-blue-500/10 text-blue-300 border border-blue-400/20 rounded-full px-4 py-1.5 text-xs font-semibold mb-6">
        <i class="mdi mdi-star-four-points"></i> Platform Pembelajaran Digital
      </div>
      <h1 class="text-5xl md:text-6xl font-extrabold text-white leading-tight mb-6" style="letter-spacing:-0.02em;font-family:'Sora',sans-serif">
        Belajar Lebih <br>
        <span style="background:linear-gradient(135deg,#60a5fa,#38bdf8);-webkit-background-clip:text;-webkit-text-fill-color:transparent">
          Cerdas & Mudah
        </span>
      </h1>
      <p class="text-slate-300 text-lg leading-relaxed mb-10 max-w-xl">
        Platform manajemen pembelajaran digital <strong class="text-white">SMKN 40 Jakarta</strong> —
        kelola mata pelajaran, tugas, kuis, dan absensi dalam satu tempat.
      </p>
      <div class="flex flex-wrap gap-4">
        <a href="{{ route('login') }}"
           class="inline-flex items-center gap-2 text-white font-bold px-7 py-3 rounded-xl text-sm"
           style="background:linear-gradient(135deg,#2563eb,#1d4ed8);box-shadow:0 4px 16px rgba(37,99,235,0.4)">
          <i class="mdi mdi-login"></i> Masuk Sekarang
        </a>
        <a href="#fitur"
           class="inline-flex items-center gap-2 text-white font-semibold px-7 py-3 rounded-xl text-sm border border-white/20 hover:border-white/40 hover:bg-white/5 transition-all">
          <i class="mdi mdi-play-circle-outline"></i> Lihat Fitur
        </a>
      </div>
    </div>

    {{-- Stats --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-16">
      @foreach([['500+','Siswa Aktif'],['40+','Guru'],['120+','Mata Pelajaran'],['98%','Kepuasan']] as $s)
      <div class="rounded-2xl p-5 text-center transition-all hover:-translate-y-1"
           style="background:rgba(255,255,255,0.05);border:1px solid rgba(255,255,255,0.1);backdrop-filter:blur(14px)">
        <div class="text-3xl font-extrabold text-white mb-1" style="font-family:'Sora',sans-serif">{{ $s[0] }}</div>
        <div class="text-slate-400 text-sm">{{ $s[1] }}</div>
      </div>
      @endforeach
    </div>
  </div>
</section>

{{-- ── FITUR ── --}}
<section id="fitur" class="py-24 bg-slate-50">
    <div class="max-w-6xl mx-auto px-6 mt-5 mb-4">
        <div class="text-center">
            <div class="inline-flex items-center gap-2 bg-blue-50 text-blue-600 border border-blue-100 rounded-full px-4 py-1.5 text-xs font-semibold mb-4">
                <i class="mdi mdi-land-plots"></i> Tampilan
            </div>
        </div>
        <div class="clean-look-container">
            <div class="kolom-teks-fitur">
                <h2 class="text-3xl md:text-4xl font-extrabold text-slate-900 mb-3" style="letter-spacing:-0.02em;font-family:'Sora',sans-serif">Tampilan yang bersih</h2>
                <p class="text-slate-500 max-w-md text-sm leading-relaxed">Tampilan yang bersih dan responsive untuk mudah di pahami untuk memudahkan pengguna dalam aksesbilitas fitur fitur!</p>
                
                <div class="fitur-grid text-center">
                    <div class="fitur-item">
                       <div class="inline-flex gap-2 mt-4 text-white font-semibold px-7 py-3 rounded-xl transition-all" style="background:linear-gradient(135deg,#2563eb,#1d4ed8);box-shadow:0 4px 16px rgba(37,99,235,0.4)">
                            <i class="mdi mdi-monitor-shimmer md:text-4xl"></i>
                        </div><br>
                        <div class="text-center mt-4">
                            <h2 class="font-bold">Tampilan Bersih</h2>
                            <p class="mt-2 text-left" >Tampilan dengan clean look dan simple.</p>
                        </div>
                    </div>

                    <div class="fitur-item">
                       <div class="inline-flex  gap-2 mt-4 text-white font-semibold px-7 py-3 rounded-xl transition-all" style="background:linear-gradient(135deg,#65b546,#30a54f);box-shadow:0 4px 16px rgba(53, 191, 56, 0.4)">
                            <i class="mdi mdi-land-plots md:text-4xl"></i>
                        </div><br>
                        <div class="text-center mt-4">
                            <h2 class="font-bold">Layout Mudah</h2>
                            <p class="mt-2 text-left">Memiliki layout yang mudah di mengerti user.</p>
                        </div>
                    </div>

                    <div class="fitur-item">
                       <div class="inline-flex  gap-2 mt-4 text-white font-semibold px-7 py-3 rounded-xl transition-all" style="background:linear-gradient(135deg,#2563eb,#1d4ed8);box-shadow:0 4px 16px rgba(37,99,235,0.4)">
                            <i class="mdi mdi-cog md:text-4xl"></i>
                        </div><br>
                        <div class="text-center mt-4">
                            <h2 class="font-bold">Icon yang familiar</h2>
                            <p class="mt-2 text-left" >Tampilan dengan icon familiar.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="kolom-visual-preview" style="margin-top: 30vh">

                <div class="absolute bottom-0 left-0 right-10 z-0">
                    <div class="img-desktop-wrapper">
                        <img src="images/screenshot/Desktop.png" 
                            alt="Desktop screenshot" 
                            class="w-full rounded-2xl shadow-2xl"
                            style="box-shadow: 0 25px 60px rgba(0,0,0,0.4)">
                    </div>
                </div>

                <div class="absolute bottom-0 right-0 z-20" style="width: 65vh">
                    <div class="img-mobile-wrapper">
                        <img src="images/screenshot/Mobile.png" 
                            alt="Mobile screenshot" 
                            class="w-full rounded-2xl shadow-2xl"
                            style="box-shadow: 0 20px 50px rgba(0,0,0,0.5)">
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="max-w-6xl mx-auto px-6" style="margin-top: 120px">
        <div class="text-center mb-16">
            <div class="inline-flex items-center gap-2 bg-blue-50 text-blue-600 border border-blue-100 rounded-full px-4 py-1.5 text-xs font-semibold mb-4">
                <i class="mdi mdi-apps"></i> Fitur Unggulan
            </div>
            <h2 class="text-3xl md:text-4xl font-extrabold text-slate-900 mb-3" style="letter-spacing:-0.02em;font-family:'Sora',sans-serif">
                Semua yang Kamu Butuhkan
            </h2>
            <p class="text-slate-500 max-w-md mx-auto text-sm leading-relaxed">Platform lengkap untuk mendukung kegiatan belajar mengajar secara digital</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach([
            ['mdi-book-open-variant','blue','Mata Pelajaran Digital','Kelola materi, modul, dan pelajaran secara terstruktur dengan sistem yang mudah diakses kapan saja.'],
            ['mdi-clipboard-check','green','Tugas & Pengumpulan','Buat tugas, terima pengumpulan file atau link, dan beri penilaian langsung dari platform.'],
            ['mdi-brain','purple','Kuis Interaktif','Buat kuis dengan batas waktu, nilai otomatis, dan pantau hasil setiap siswa secara real-time.'],
            ['mdi-clipboard-account','amber','Absensi Digital','Catat kehadiran siswa per kelas dan mata pelajaran, lengkap dengan rekap mingguan.'],
            ['mdi-chart-line','cyan','Analitik & Laporan','Dashboard lengkap dengan grafik progress belajar, absensi, dan performa siswa.'],
            ['mdi-message-text','rose','Konseling Online','Layanan bimbingan konseling digital antara siswa dan guru BK langsung dalam platform.'],
        ] as $f)
        <div class="bg-white rounded-2xl p-7 border border-slate-100 transition-all duration-300 hover:-translate-y-1.5 hover:shadow-xl hover:border-blue-100">
            <div class="w-12 h-12 rounded-xl bg-{{ $f[1] }}-50 flex items-center justify-center mb-5">
            <i class="mdi {{ $f[0] }} text-{{ $f[1] }}-600 text-2xl"></i>
            </div>
            <h3 class="font-bold text-slate-900 text-lg mb-2">{{ $f[2] }}</h3>
            <p class="text-slate-500 text-sm leading-relaxed">{{ $f[3] }}</p>
        </div>
        @endforeach
        </div>
    </div>
</section>

{{-- ── CARA PAKAI ── --}}
<section id="cara" class="py-24 bg-white">
  <div class="max-w-6xl mx-auto px-6">
    <div class="text-center mb-16">
      <div class="inline-flex items-center gap-2 bg-blue-50 text-blue-600 border border-blue-100 rounded-full px-4 py-1.5 text-xs font-semibold mb-4">
        <i class="mdi mdi-numeric"></i> Cara Menggunakan
      </div>
      <h2 class="text-3xl md:text-4xl font-extrabold text-slate-900 mb-3" style="letter-spacing:-0.02em;font-family:'Sora',sans-serif">
        Mudah dalam 3 Langkah
      </h2>
      <p class="text-slate-500 max-w-md mx-auto text-sm">Mulai belajar dan mengajar digital hanya dalam beberapa menit</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-10 relative">
      {{-- Connector line desktop --}}
      <div class="hidden md:block absolute top-8 h-0.5 bg-gradient-to-r from-blue-200 via-blue-400 to-blue-200"
           style="left:calc(16.7% + 20px);right:calc(16.7% + 20px)"></div>
      @foreach([
        ['1','#2563eb','Login ke Platform','Masuk menggunakan akun yang diberikan oleh sekolah. Tersedia untuk siswa, guru, dan admin.'],
        ['2','#3b82f6','Pilih Mata Pelajaran','Akses mata pelajaran yang sudah ditugaskan, buka materi, dan mulai belajar sesuai jadwal.'],
        ['3','#60a5fa','Kerjakan & Pantau','Kumpulkan tugas, ikuti kuis, dan pantau progress belajar dari dashboard.'],
      ] as $s)
      <div class="text-center relative z-10">
        <div class="w-16 h-16 rounded-2xl flex items-center justify-center mx-auto mb-5 shadow-lg"
             style="background:{{ $s[1] }};box-shadow:0 8px 20px {{ $s[1] }}40">
          <span class="text-white font-extrabold text-xl" style="font-family:'Sora',sans-serif">{{ $s[0] }}</span>
        </div>
        <h3 class="font-bold text-slate-900 text-lg mb-2">{{ $s[2] }}</h3>
        <p class="text-slate-500 text-sm leading-relaxed">{{ $s[3] }}</p>
      </div>
      @endforeach
    </div>
  </div>
</section>

{{-- ── ROLE ── --}}
<section class="py-24 bg-slate-900 relative overflow-hidden">
  <div class="absolute w-96 h-96 rounded-full bg-blue-700 opacity-10 blur-3xl" style="top:-160px;right:-80px"></div>
  <div class="max-w-6xl mx-auto px-6 relative z-10">
    <div class="text-center mb-14">
      <h2 class="text-3xl md:text-4xl font-extrabold text-white mb-3" style="letter-spacing:-0.02em;font-family:'Sora',sans-serif">
        Untuk Semua Peran
      </h2>
      <p class="text-slate-400 max-w-sm mx-auto text-sm">Satu platform, tiga pengalaman yang disesuaikan kebutuhan</p>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
      @foreach([
        ['mdi-account-school','Siswa','Akses materi, kumpulkan tugas, ikuti kuis, dan pantau progress belajar secara mandiri.',['Lihat materi & modul','Kumpul tugas online','Dashboard progress'],false],
        ['mdi-account-tie','Guru','Buat materi, kelola tugas & kuis, catat absensi, dan pantau perkembangan siswa.',['Buat & kelola konten','Catat absensi digital','Grafik performa siswa'],true],
        ['mdi-shield-account','Admin','Kelola seluruh platform, manajemen pengguna, kelas, dan pantau analitik lengkap.',['Manajemen pengguna','Kelola kelas & jurusan','Analitik platform penuh'],false],
      ] as $r)
      <div class="rounded-2xl p-8 relative transition-all duration-300 hover:-translate-y-1"
           style="{{ $r[4] ? 'background:rgba(37,99,235,0.12);border:1px solid rgba(59,130,246,0.4)' : 'background:rgba(255,255,255,0.04);border:1px solid rgba(255,255,255,0.08)' }}">
        @if($r[4])
        <div class="absolute -top-3 left-1/2 -translate-x-1/2 bg-blue-600 text-white text-xs font-bold px-3 py-1 rounded-full">Populer</div>
        @endif
        <div class="text-blue-400 text-4xl mb-4"><i class="mdi {{ $r[0] }}"></i></div>
        <h3 class="text-white text-xl font-bold mb-3" style="font-family:'Sora',sans-serif">{{ $r[1] }}</h3>
        <p class="text-slate-400 text-sm leading-relaxed mb-5">{{ $r[2] }}</p>
        <ul class="space-y-2">
          @foreach($r[3] as $item)
          <li class="flex items-center gap-2 text-slate-300 text-sm">
            <i class="mdi mdi-check-circle text-blue-400"></i> {{ $item }}
          </li>
          @endforeach
        </ul>
      </div>
      @endforeach
    </div>
  </div>
</section>

{{-- ── FAQ ── --}}
<section class="py-24 bg-slate-50" id="login">
  <div class="max-w-6xl mx-auto px-6">

    <div class="text-center" style="margin-bottom: 28px">
      <div class="inline-flex items-center gap-2 bg-blue-50 text-blue-600 border border-blue-100 rounded-full px-4 py-1.5 text-xs font-semibold mb-4">
        <i class="mdi mdi-help-circle-outline"></i> FAQ
      </div>
      <h2 class="text-3xl md:text-4xl font-extrabold text-slate-900 mb-3" style="font-family:'Sora',sans-serif;letter-spacing:-0.02em">
        Pertanyaan yang Sering <br>Ditanyakan
      </h2>
      <p class="text-slate-500 text-sm">Semua yang perlu kamu tahu tentang platform LMS SMKN 40 Jakarta</p>
    </div>

    <div class="faq-grid-container">

      {{-- Kiri: FAQ Accordion --}}
      <div class="faq-kolom-accordion">
        @foreach([
          ['q'=>'Apa itu LMS?','a'=>'LMS (Learning Management System) adalah platform digital untuk mengelola, mendistribusikan, dan memantau proses belajar mengajar secara online. Di SMKN 40 Jakarta, LMS menggantikan proses manual seperti absensi kertas dan pengumpulan tugas fisik.','icon'=>'mdi-monitor-dashboard'],
          ['q'=>'Siapa saja yang bisa menggunakan?','a'=>'Tersedia untuk tiga peran: Siswa yang terdaftar di SMKN 40 Jakarta, Guru/Instruktur yang mengampu mata pelajaran, dan Admin sekolah yang mengelola seluruh platform.','icon'=>'mdi-account-group-outline'],
          ['q'=>'Fitur apa saja yang tersedia?','a'=>'Platform dilengkapi Mata Pelajaran Digital, Pengumpulan Tugas (file & link), Kuis Interaktif dengan nilai otomatis, Absensi Digital, Bimbingan Konseling Online, serta Dashboard Analitik untuk memantau progress belajar.','icon'=>'mdi-apps'],
        ] as $i => $faq)
        <div class="faq-item mb-2 bg-white rounded-2xl border border-slate-100 overflow-hidden transition-all duration-300 hover:border-blue-100 hover:shadow-sm"
             style="cursor:pointer" onclick="toggleFaq({{ $i }})">
          <div class="flex items-center gap-3 p-4">
            <div class="w-9 h-9 rounded-xl bg-blue-50 flex items-center justify-center flex-shrink-0">
              <i class="mdi {{ $faq['icon'] }} text-blue-600 px-3"></i>
            </div>
            <span class="font-semibold text-slate-800 text-sm flex-1 leading-snug">{{ $faq['q'] }}</span>
            <div id="faq-icon-{{ $i }}" class="w-7 h-7 rounded-lg bg-slate-100 flex items-center justify-center flex-shrink-0">
              <i class="mdi mdi-chevron-down text-slate-500 transition-transform duration-300" id="faq-chevron-{{ $i }}"></i>
            </div>
          </div>
          <div id="faq-answer-{{ $i }}" class="hidden px-4 pb-4">
            <p class="text-slate-500 text-sm leading-relaxed pl-12 border-l-2 border-blue-100 ml-12">
              {{ $faq['a'] }}
            </p>
          </div>
        </div>
        @endforeach
      </div>

      {{-- Kanan: Gambar --}}
      <div class="faq-kolom-gambar">
        <div class="relative w-full">
          {{-- Glow effect --}}
          <div class="absolute inset-0 rounded-3xl blur-3xl opacity-10"
               style="background:linear-gradient(135deg,#3e475a,#809097);transform:scale(0.9) translateY(20px)"></div>
          <img src="{{ asset('images/screenshot/Desktop.png') }}"
               alt="Preview Platform LMS"
               class="relative w-full rounded-2xl shadow-2xl"
               style="box-shadow:0 30px 70px rgba(37,99,235,0.2)">
        </div>
      </div>

    </div>
  </div>
</section>

{{-- ── Tentang Kami ── --}}
<section class="py-24 bg-white section-tentang" id="tentangkami">
  <div class="max-w-6xl mx-auto px-6 text-center">

    <div class="inline-flex items-center gap-2 bg-blue-50 text-blue-600 border border-blue-100 rounded-full px-4 py-1.5 text-xs font-semibold mb-4">
       <i class="mdi mdi-information-outline"></i> Tentang Kami
    </div>

    <div class="grid-container">
      <div class="kolom-teks">
        <h2 class="text-3xl md:text-4xl font-extrabold text-slate-900 mb-6 leading-tight" style="font-family:'Sora',sans-serif;letter-spacing:-0.02em">
          SMKN 40 <span style="background:linear-gradient(135deg,#2563eb,#38bdf8);-webkit-background-clip:text;-webkit-text-fill-color:transparent">Jakarta</span>
        </h2>

        <p class="text-slate-600 text-base text-left leading-relaxed mb-8">
          Sekolah Menengah Kejuruan Negeri 40 Jakarta adalah sekolah menengah kejuruan negeri 
          <strong class="text-slate-800">berakreditasi A</strong> di Daerah Khusus Ibu Kota Jakarta 
          dengan bidang keahlian <strong class="text-slate-800">Bisnis dan Manajemen</strong> serta 
          <strong class="text-slate-800">Teknologi Informasi dan Komunikasi</strong>. SMK Negeri 40 
          Jakarta berlokasi di Utan Kayu Utara, Matraman, Jakarta Timur.
        </p>

        {{-- Info chips --}}
        <div class="flex flex-col gap-3 text-left">
          <div class="flex items-start gap-3 p-4 rounded-xl bg-slate-50 border border-slate-100">
            <div class="w-9 h-9 rounded-lg bg-blue-50 flex items-center justify-center flex-shrink-0">
              <i class="mdi mdi-school text-blue-600  px-3 py-2"></i>
            </div>
            <div>
              <div class="text-sm font-semibold text-slate-800">Akreditasi</div>
              <div class="text-sm text-slate-500">A — Unggul</div>
            </div>
          </div>

          <div class="flex items-start gap-3 p-4 rounded-xl bg-slate-50 border border-slate-100">
            <div class="w-9 h-9 rounded-lg bg-blue-50 flex items-center justify-center flex-shrink-0">
              <i class="mdi mdi-briefcase text-blue-600  px-3 py-2"></i>
            </div>
            <div>
              <div class="text-sm font-semibold text-slate-800">Bidang Keahlian</div>
              <div class="text-sm text-slate-500">Bisnis & Manajemen · Teknologi Informasi & Komunikasi</div>
            </div>
          </div>

          <div class="flex items-start gap-3 p-4 rounded-xl bg-slate-50 border border-slate-100">
            <div class="w-9 h-9 rounded-lg bg-blue-50 flex items-center justify-center flex-shrink-0">
              <i class="mdi mdi-map-marker text-blue-600 px-3 py-2"></i>
            </div>
            <div>
              <div class="text-sm font-semibold text-slate-800">Lokasi</div>
              <div class="text-sm text-slate-500 ">Utan Kayu Utara, Matraman, Jakarta Timur</div>
            </div>
          </div>
        </div>
      </div>

      {{-- Kanan: Maps --}}
      <div class="kolom-maps">
        <div class="maps-wrapper">
          <iframe
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.3!2d106.8737!3d-6.2028!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f3e5b5b5b5b5%3A0x0!2sJl.+Nanas+II+No.9%2C+RT.9%2FRW.10%2C+Utan+Kayu+Utara%2C+Kec.+Matraman%2C+Kota+Jakarta+Timur%2C+Daerah+Khusus+Ibukota+Jakarta+13120!5e0!3m2!1sen!2sid!4v1620000000000!5m2!1sen!2sid"
            width="100%"
            height="100%"
            style="border:0"
            allowfullscreen=""
            loading="lazy"
            referrerpolicy="no-referrer-when-downgrade"
            title="Lokasi SMKN 40 Jakarta">
          </iframe>
        </div>

        {{-- Alamat di bawah maps --}}
        <div class="flex items-start gap-3 p-4 rounded-xl border border-slate-100 bg-slate-50 mt-4">
          <div class="w-9 h-9 rounded-lg bg-blue-50 flex items-center justify-center flex-shrink-0 mt-0.5">
            <i class="mdi mdi-map-marker-outline text-blue-600 px-3"></i>
          </div>
          <div>
            <div class="text-sm font-semibold text-slate-800 mb-0.5 text-left">Alamat Lengkap</div>
            <div class="text-sm text-left text-slate-500 leading-relaxed">
              Jl. Nanas II No.9, RT.9/RW.10, Utan Kayu Utara,<br>
              Kec. Matraman, Kota Jakarta Timur,
              DKI Jakarta 13120
            </div>
          </div>
          <a href="https://maps.google.com/?q=Jl.+Nanas+II+No.9+Utan+Kayu+Utara+Matraman+Jakarta+Timur"
             target="_blank"
             class="ml-auto flex-shrink-0 inline-flex items-center gap-1 text-xs font-semibold text-blue-600 hover:text-blue-700 no-underline transition-colors">
            Buka Maps <i class="mdi mdi-open-in-new text-sm"></i>
          </a>
        </div>
      </div>

    </div>
  </div>
</section>

{{-- ── CTA ── --}}
<section class="py-24 bg-white text-center">
  <div class="max-w-2xl mx-auto px-6">
    <div class="inline-flex items-center gap-2 bg-blue-50 text-blue-600 border border-blue-100 rounded-full px-4 py-1.5 text-xs font-semibold mb-6">
      <i class="mdi mdi-rocket-launch"></i> Login
    </div>
    <h2 class="text-4xl font-extrabold text-slate-900 mb-4 leading-tight" style="letter-spacing:-0.02em;font-family:'Sora',sans-serif">
      Siap Memulai Perjalanan <br>
      <span style="background:linear-gradient(135deg,#2563eb,#0ea5e9);-webkit-background-clip:text;-webkit-text-fill-color:transparent">
        Belajar Digital?
      </span>
    </h2>
    <p class="text-slate-500 text-lg mb-10">Masuk dengan akun yang diberikan sekolah dan mulai belajar hari ini.</p>
    <a href="{{ route('login') }}"
       class="inline-flex items-center gap-2 text-white font-bold px-10 py-4 rounded-2xl text-lg"
       style="background:linear-gradient(135deg,#2563eb,#1d4ed8);box-shadow:0 4px 16px rgba(37,99,235,0.4)">
      <i class="mdi mdi-login"></i> Masuk ke Platform
    </a>
  </div>
</section>

@endsection

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Sora:wght@700;800&display=swap" rel="stylesheet">
<style>
  @keyframes floatBlob { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-28px)} }

/* --- Tampilan Mobile (Default) --- */
.clean-look-container {
    display: flex;
    flex-direction: column;
    gap: 3rem;
}

/* Styling Visual Gambar */
.visual-wrapper {
    position: relative;
    width: 100%;
    aspect-ratio: 16/9; /* Menjaga ruang untuk gambar absolute */
    margin-bottom: 2rem;
}

.img-desktop {
    width: 90%;
    border-radius: 1rem;
    box-shadow: 0 15px 40px rgba(0,0,0,0.2);
}

.img-mobile-wrapper {
    position: absolute;
    bottom: -10%;
    right: 0;
    width: 30%;
    z-index: 10;
}

.img-mobile {
    width: 100%;
    border-radius: 0.75rem;
    box-shadow: 0 10px 30px rgba(0,0,0,0.3);
}

/* Grid Fitur di Mobile (bisa 1 kolom atau tetap 3 jika muat) */
.fitur-grid {
    display: grid;
    grid-template-columns: 1fr; /* Di HP 1 kolom saja biar tidak sempit */
    gap: 1.5rem;
    text-align: center;
}

/* --- Tampilan Desktop --- */
@media (min-width: 1024px) {
    .clean-look-container {
        display: grid;
        grid-template-columns: 1fr 1fr;
        align-items: center;
        gap: 4rem;
    }

    /* Tukar Posisi: Teks ke Kiri (1), Gambar ke Kanan (2) */
    .kolom-teks-fitur {
        grid-column: 1;
        grid-row: 1;
    }

    .kolom-visual-preview {
        grid-column: 2;
        grid-row: 1;
    }

    .fitur-grid {
        grid-template-columns: repeat(3, 1fr); /* Kembali 3 kolom di desktop */
        text-align: left;
    }
}

/* Helper Classes */
.bg-blue-gradient { background: linear-gradient(135deg,#2563eb,#1d4ed8); }
.bg-green-gradient { background: linear-gradient(135deg,#65b546,#30a54f); }
.icon-box {
    display: inline-flex;
    padding: 0.75rem 1.75rem;
    border-radius: 0.75rem;
    color: white;
    font-size: 1.5rem;
}
.faq-grid-container {
  display: flex;
  flex-direction: column;
  gap: 3rem; /* Jarak antara gambar dan faq di mobile */
}

.img-preview {
  width: 100%;
  border-radius: 1.5rem;
  box-shadow: 0 20px 50px rgba(0, 0, 0, 0.1);
}

.faq-item {
  background: white;
  border-radius: 1.25rem;
  border: 1px solid #f1f5f9;
  transition: all 0.3s ease;
  cursor: pointer;
}

.faq-item:hover {
  border-color: #dbeafe;
  box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
}

/* --- Tampilan Desktop --- */
@media (min-width: 1024px) {
  .faq-grid-container {
    display: grid;
    grid-template-columns: 1fr 1fr; /* Bagi dua seimbang */
    align-items: center;
    gap: 4rem;
  }

  /* Tukar Posisi: Accordion ke Kiri (1), Gambar ke Kanan (2) */
  .faq-kolom-accordion {
    grid-column: 1;
    grid-row: 1;
  }

  .faq-kolom-gambar {
    grid-column: 2;
    grid-row: 1;
  }
}
.grid-container {
  display: flex;
  flex-direction: column; /* Menumpuk ke bawah */
  gap: 2rem;
}

.maps-wrapper {
  height: 300px;
  border-radius: 1rem;
  overflow: hidden;
  box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
}

/* --- Tampilan Desktop (Layar Lebar) --- */
@media (min-width: 1024px) {
  .grid-container {
    display: grid;
    grid-template-columns: 1fr 1fr; /* Bagi dua kolom */
    align-items: start;
    gap: 3rem;
  }

  /* Kita balik urutannya: Teks jadi ke Kiri (1), Maps jadi ke Kanan (2) */
  .kolom-teks {
    grid-column: 1;
    grid-row: 1;
  }

  .kolom-maps {
    grid-column: 2;
    grid-row: 1;
  }
  
  .maps-wrapper {
    height: 380px;
  }
}
</style>
@endpush

@push('scripts')
<script>
document.querySelectorAll('a[href^="#"]').forEach(a => {
  a.addEventListener('click', e => {
    const t = document.querySelector(a.getAttribute('href'));
    if (t) { e.preventDefault(); t.scrollIntoView({ behavior:'smooth' }); }
  });
});

function toggleFaq(index) {
  const answer  = document.getElementById('faq-answer-'  + index);
  const chevron = document.getElementById('faq-chevron-' + index);
  const iconBox = document.getElementById('faq-icon-'    + index);
  const isOpen  = !answer.classList.contains('hidden');

  // Tutup semua
  document.querySelectorAll('[id^="faq-answer-"]').forEach(el => el.classList.add('hidden'));
  document.querySelectorAll('[id^="faq-chevron-"]').forEach(el => el.style.transform = 'rotate(0deg)');
  document.querySelectorAll('[id^="faq-icon-"]').forEach(el => {
    el.style.background = '#f1f5f9';
    el.querySelector('i').style.color = '#64748b';
  });

  // Buka yang diklik
  if (!isOpen) {
    answer.classList.remove('hidden');
    chevron.style.transform    = 'rotate(180deg)';
    iconBox.style.background   = '#eff6ff';
    iconBox.querySelector('i').style.color = '#2563eb';
  }
}
</script>
@endpush