@extends('layouts.app')

@section('title', 'Tentang Kami')

@section('content')
    <div class="container py-5">

        <!-- Hero Section -->
        <div class="row align-items-center mb-5">
            <div class="col-lg-6 mb-4 mb-lg-0">
                <h1 class="display-4 fw-bold mb-3">Tentang <span class="text-orange">HomeVora</span></h1>
                <p class="lead mb-4">Menciptakan Ruangan Impian Anda dengan Furniture Berkualitas</p>
                <p class="mb-4">HomeVora hadir sebagai solusi terpercaya untuk memenuhi kebutuhan furniture dan dekorasi
                    rumah Anda. Dengan pengalaman lebih dari 10 tahun di industri interior, kami berkomitmen untuk
                    menghadirkan produk berkualitas tinggi dengan desain modern yang sesuai dengan tren terkini.</p>
                <div class="d-flex gap-3">
                    <div class="text-center">
                        <h3 class="fw-bold text-orange">5000+</h3>
                        <p class="text-muted">Produk Terjual</p>
                    </div>
                    <div class="text-center">
                        <h3 class="fw-bold text-orange">1000+</h3>
                        <p class="text-muted">Pelanggan Puas</p>
                    </div>
                    <div class="text-center">
                        <h3 class="fw-bold text-orange">50+</h3>
                        <p class="text-muted">Brand Partner</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <img src="{{ asset('images/background home.jpg') }}" alt="Tentang HomeVora"
                    class="img-fluid rounded-3 shadow-lg">
            </div>
        </div>

        <!-- Visi & Misi -->
        <div class="row g-4 mb-5">
            <div class="col-md-6">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body p-4">
                        <div class="text-center mb-3">
                            <i class="bi bi-eye fs-1 text-orange"></i>
                        </div>
                        <h3 class="text-center mb-3">Visi</h3>
                        <p class="text-center text-muted">Menjadi platform terdepan dalam menyediakan solusi interior
                            berkualitas yang dapat diakses oleh seluruh masyarakat Indonesia, menciptakan ruangan yang
                            nyaman dan estetis untuk setiap keluarga.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body p-4">
                        <div class="text-center mb-3">
                            <i class="bi bi-bullseye fs-1 text-orange"></i>
                        </div>
                        <h3 class="text-center mb-3">Misi</h3>
                        <ul class="text-muted">
                            <li class="mb-2">Menyediakan produk furniture berkualitas dengan harga terbaik</li>
                            <li class="mb-2">Memberikan pengalaman berbelanja yang mudah dan aman</li>
                            <li class="mb-2">Mendukung desainer lokal dalam mengembangkan karyanya</li>
                            <li class="mb-2">Berkomitmen pada keberlanjutan lingkungan</li>
                            <li>Memberikan layanan pelanggan yang responsif dan profesional</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Nilai Perusahaan -->
        <div class="mb-5">
            <h2 class="text-center mb-4">Nilai Perusahaan</h2>
            <div class="row g-4">
                <div class="col-md-3">
                    <div class="text-center">
                        <i class="bi bi-gem fs-1 text-orange"></i>
                        <h5 class="mt-2">Kualitas</h5>
                        <p class="small text-muted">Produk terjamin kualitasnya</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="text-center">
                        <i class="bi bi-lightbulb fs-1 text-orange"></i>
                        <h5 class="mt-2">Inovasi</h5>
                        <p class="small text-muted">Desain modern & kreatif</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="text-center">
                        <i class="bi bi-people fs-1 text-orange"></i>
                        <h5 class="mt-2">Kepercayaan</h5>
                        <p class="small text-muted">Transparan & jujur</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="text-center">
                        <i class="bi bi-tree fs-1 text-orange"></i>
                        <h5 class="mt-2">Ramah Lingkungan</h5>
                        <p class="small text-muted">Material berkelanjutan</p>
                    </div>
                </div>
            </div>
        </div>


        <!-- Hubungi Kami -->
        <div class="row align-items-center">
            <div class="col-lg-8 mx-auto text-center">
                <h2 class="mb-3">Siap Mewujudkan Ruangan Impian?</h2>
                <p class="lead mb-4">Hubungi kami sekarang untuk konsultasi gratis dengan desainer interior profesional
                    kami.</p>
                <div class="d-flex justify-content-center gap-3">
                    <a href="#" class="btn btn-orange btn-lg">
                        <i class="bi bi-whatsapp"></i> Chat WhatsApp
                    </a>
                    <a href="#" class="btn btn-outline-secondary btn-lg">
                        <i class="bi bi-envelope"></i> Email Kami
                    </a>
                </div>
            </div>
        </div>
    </div>

    @push('styles')
        <style>
            .text-orange {
                color: #987456;
            }

            .hover-card {
                transition: transform 0.3s ease;
            }

            .hover-card:hover {
                transform: translateY(-5px);
            }

            .rounded-circle {
                border: 3px solid #e67e22;
                padding: 3px;
            }

            .social-links a {
                transition: color 0.3s ease;
            }

            .social-links a:hover {
                color: #e67e22 !important;
            }

            .bg-light {
                background-color: #f8f9fa !important;
            }

            .breadcrumb a {
                color: #e67e22;
            }

            .breadcrumb a:hover {
                color: #d35400;
            }
        </style>
    @endpush
@endsection
