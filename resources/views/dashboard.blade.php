<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-[#C5B358] leading-tight text-center">
            {{ __('Pengaduan Sistem Informasi Mahasiswa Teknologi Informasi') }}
        </h2>
    </x-slot>

    <!-- Welcome Box -->
    <div class="py-12 bg-[#1a0000] font-[Figtree,sans-serif]">
        <div class="max-w-5xl mx-auto px-6">
            <div class="bg-[#450000] text-white rounded-lg shadow-lg p-8 border border-gray-700 text-center">
                <p class="text-lg font-semibold text-green-300">
                    {{ __("You're logged in!") }}
                </p>
                <p class="mt-4 text-sm text-gray-300">
                    Selamat datang di dashboard! Silakan gunakan menu navigasi untuk mengakses fitur sistem pengaduan.
                </p>
            </div>
        </div>
    </div>

    <!-- Carousel Section -->
    <div class="pb-12">
        <div class="max-w-5xl mx-auto px-6">
            <div id="loginCarousel" class="carousel slide carousel-fade rounded-lg overflow-hidden shadow-lg" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="{{ asset('images/crsl1.JPG') }}" class="d-block w-100 object-cover" style="height: 400px;" alt="Slide 1">
                        <div class="carousel-caption d-none d-md-block bg-dark bg-opacity-50 rounded">
                            <h5>Selamat Datang!</h5>
                            <p>Sistem Informasi Pengaduan Mahasiswa TI</p>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <img src="{{ asset('images/crsl2.JPG') }}" class="d-block w-100 object-cover" style="height: 400px;" alt="Slide 2">
                        <div class="carousel-caption d-none d-md-block bg-dark bg-opacity-50 rounded">
                            <h5>Layanan Mudah</h5>
                            <p>Laporkan keluhan Anda dengan cepat.</p>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <img src="{{ asset('images/crsl3.JPG') }}" class="d-block w-100 object-cover" style="height: 400px;" alt="Slide 3">
                        <div class="carousel-caption d-none d-md-block bg-dark bg-opacity-50 rounded">
                            <h5>Transparansi</h5>
                            <p>Proses adil & terbuka untuk setiap laporan.</p>
                        </div>
                    </div>
                </div>

                <!-- Controls -->
                <button class="carousel-control-prev" type="button" data-bs-target="#loginCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Sebelumnya</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#loginCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Berikutnya</span>
                </button>
            </div>
        </div>
    </div>
</x-app-layout>
