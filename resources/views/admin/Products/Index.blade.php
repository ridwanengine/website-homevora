@extends('layouts.admin')

@section('title', 'Manajemen Produk')
@section('page-title', 'Manajemen Produk')

@push('styles')
    <style>
        .no-spinner::-webkit-outer-spin-button,
        .no-spinner::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        .no-spinner {
            -moz-appearance: textfield;
        }

        .border-dashed {
            border-style: dashed !important;
        }

        .form-control:focus {
            border-color: #866347 !important;
            box-shadow: 0 0 0 0.25rem rgba(134, 99, 71, 0.25) !important;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(134, 99, 71, 0.3);
        }

        .btn-light:hover {
            background: #e9ecef !important;
            transform: translateY(-2px);
        }
    </style>
@endpush

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#products-table').DataTable({
                paging: false, // 
                searching: true,
                info: false,
                lengthChange: false
            });

            $('.delete-product').click(function(e) {
                e.preventDefault();
                if (confirm('Apakah Anda yakin ingin menghapus produk ini?')) {
                    $(this).closest('form').submit();
                }
            });
        });
    </script>
@endpush

@section('content')

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5>Daftar Produk</h5>
            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addModal">
                + Tambah Produk
            </button>
        </div>

        <div class="card-body">
            <table class="table table-hover" id="products-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Gambar</th>
                        <th style="text-align: center">Nama</th>
                        <th style="text-align: center">Deskripsi</th>
                        <th style="text-align:center; width:120px;">Harga</th>
                        <th style="text-align:center; width:120px;">Stok</th>
                        <th style="text-align:center; width:120px;">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($products as $index => $product)
                        <tr>
                            <td>{{ $index + 1 }}</td>

                            <td>
                                @if ($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" width="50">
                                @else
                                    -
                                @endif
                            </td>

                            <td>{{ $product->name }}</td>
                            <td>{{ Str::limit($product->description, 50) }}</td>
                            <td>Rp {{ number_format($product->price) }}</td>

                            {{-- Stok --}}
                            <td class="text-center align-middle">
                                @if ($product->stock > 0)
                                    <span class="badge bg-success">{{ $product->stock }}</span>
                                @else
                                    <span class="badge bg-danger">Habis</span>
                                @endif
                            </td>


                            {{-- Aksi --}}
                            <td>
                                <!-- DETAIL -->
                                <button class="btn btn-info btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#detail{{ $product->id }}">
                                    <i class="fas fa-eye"></i>
                                </button>

                                <!-- EDIT -->
                                <button class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#edit{{ $product->id }}">
                                    <i class="fas fa-pen"></i>
                                </button>

                                <!-- DELETE -->
                                <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST"
                                    class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm delete-product">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>

                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- ================= DETAIL ================= --}}
    @foreach ($products as $product)
        <div class="modal fade" id="detail{{ $product->id }}">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content rounded-3 shadow">

                    <!-- HEADER -->
                    <div class="modal-header">
                        <h5 class="modal-title fw-bold">Detail Produk</h5>
                        <button class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <!-- BODY -->
                    <div class="modal-body px-4 py-3">

                        <!-- GAMBAR -->
                        @if ($product->image)
                            <div class="text-center mb-3">
                                <img src="{{ asset('storage/' . $product->image) }}" class="img-fluid rounded"
                                    style="max-width:220px; object-fit:cover;">
                            </div>
                        @endif

                        <!-- INFO -->
                        <div class="product-detail">

                            <p class="mb-2">
                                <strong>Nama:</strong><br>
                                {{ $product->name }}
                            </p>

                            <!-- DESKRIPSI DENGAN POIN -->
                            <div class="mb-2">
                                <strong>Deskripsi:</strong>
                                <ul class="mt-2 ps-3">
                                    @foreach (explode("\n", $product->description) as $desc)
                                        @if (trim($desc) != '')
                                            <li class="text-justify">{{ $desc }}</li>
                                        @endif
                                    @endforeach
                                </ul>
                            </div>

                            <p class="mb-2">
                                <strong>Harga:</strong>
                                Rp {{ number_format($product->price) }}
                            </p>

                            <p class="mb-0">
                                <strong>Stok:</strong>
                                @if ($product->stock > 0)
                                    <span class="badge bg-success">{{ $product->stock }}</span>
                                @else
                                    <span class="badge bg-danger">Habis</span>
                                @endif
                            </p>

                        </div>

                    </div>

                </div>
            </div>
        </div>
    @endforeach

    {{-- Modal Edit --}}
    @foreach ($products as $product)
        <div class="modal fade" id="edit{{ $product->id }}" tabindex="-1"
            aria-labelledby="editModalLabel{{ $product->id }}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content border-0 shadow-lg" style="border-radius: 16px; overflow: hidden;">

                    <form action="{{ route('admin.products.update', $product->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        {{-- HEADER dengan warna #866347 --}}
                        <div class="modal-header" style="background: #866347; border-bottom: none; padding: 20px 28px;">
                            <h5 class="modal-title text-white fw-bold" id="editModalLabel{{ $product->id }}">
                                <i class="fas fa-edit me-2"></i> Edit Produk
                            </h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>

                        {{-- BODY --}}
                        <div class="modal-body" style="padding: 28px; background: #fafbfc;">

                            {{-- Preview Gambar --}}
                            @if ($product->image)
                                <div class="text-center mb-4">
                                    <div class="position-relative d-inline-block">
                                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                                            class="img-fluid rounded-3 shadow-sm"
                                            style="width: 120px; height: 120px; object-fit: cover; border: 3px solid #866347;">
                                        <span class="position-absolute top-0 end-0 badge bg-primary rounded-circle p-2"
                                            style="transform: translate(50%, -50%);">
                                            <i class="fas fa-camera fa-xs"></i>
                                        </span>
                                    </div>
                                    <p class="text-muted small mt-2">
                                        <i class="fas fa-info-circle"></i> Gambar saat ini
                                    </p>
                                </div>
                            @endif

                            <div class="row g-3">
                                {{-- NAMA --}}
                                <div class="col-12">
                                    <label class="form-label fw-semibold text-secondary">
                                        <i class="fas fa-tag me-1" style="color: #866347;"></i> Nama Produk
                                    </label>
                                    <input type="text" name="name" class="form-control form-control-lg"
                                        value="{{ $product->name }}" placeholder="Masukkan nama produk"
                                        style="border-radius: 10px; border: 2px solid #e9ecef; transition: 0.3s;">
                                </div>

                                {{-- DESKRIPSI --}}
                                <div class="col-12">
                                    <label class="form-label fw-semibold text-secondary">
                                        <i class="fas fa-align-left me-1" style="color: #866347;"></i> Deskripsi
                                    </label>
                                    <textarea name="description" class="form-control" rows="3" placeholder="Tulis deskripsi produk"
                                        style="border-radius: 10px; border: 2px solid #e9ecef; transition: 0.3s; resize: vertical;">{{ $product->description }}</textarea>
                                </div>

                                {{-- HARGA & STOK --}}
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold text-secondary">
                                        <i class="fas fa-dollar-sign me-1" style="color: #866347;"></i> Harga
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text"
                                            style="background: #866347; color: white; border: none; border-radius: 10px 0 0 10px;">
                                            Rp
                                        </span>
                                        <input type="number" name="price" class="form-control no-spinner"
                                            value="{{ $product->price }}" placeholder="0"
                                            style="border-radius: 0 10px 10px 0; border: 2px solid #e9ecef; border-left: none;">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-semibold text-secondary">
                                        <i class="fas fa-boxes me-1" style="color: #866347;"></i> Stok
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text"
                                            style="background: #866347; color: white; border: none; border-radius: 10px 0 0 10px;">
                                            <i class="fas fa-cube"></i>
                                        </span>
                                        <input type="number" name="stock" class="form-control no-spinner"
                                            value="{{ $product->stock }}" placeholder="Jumlah stok"
                                            style="border-radius: 0 10px 10px 0; border: 2px solid #e9ecef; border-left: none;">
                                    </div>
                                </div>

                                {{-- GAMBAR --}}
                                <div class="col-12">
                                    <label class="form-label fw-semibold text-secondary">
                                        <i class="fas fa-image me-1" style="color: #866347;"></i> Ganti Gambar
                                    </label>
                                    <div class="border-2 border-dashed rounded-3 p-4 text-center"
                                        style="border: 2px dashed #dee2e6; background: #f8f9fa; border-radius: 12px; transition: 0.3s;"
                                        onmouseenter="this.style.background='#f1f3f5'"
                                        onmouseleave="this.style.background='#f8f9fa'">
                                        <input type="file" name="image" class="form-control" accept="image/*"
                                            style="border: none; padding: 0; background: transparent;"
                                            onchange="previewImage(this, 'preview-{{ $product->id }}')">
                                        <div id="preview-{{ $product->id }}" class="mt-2"></div>
                                        <small class="text-muted d-block mt-2">
                                            <i class="fas fa-upload me-1"></i> Klik untuk upload gambar baru (opsional)
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- FOOTER --}}
                        <div class="modal-footer"
                            style="background: #f8f9fa; border-top: 1px solid #e9ecef; padding: 16px 28px;">
                            <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal"
                                style="border-radius: 30px; font-weight: 500;">
                                <i class="fas fa-times me-1"></i> Batal
                            </button>
                            <button type="submit" class="btn px-4 text-white"
                                style="background: #866347; border-radius: 30px; font-weight: 500; transition: 0.3s;">
                                <i class="fas fa-save me-1"></i> Simpan Perubahan
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    @endforeach

    {{-- ================= ADD ================= --}}
    <div class="modal fade" id="addModal">
        <div class="modal-dialog">
            <div class="modal-content">

                <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="modal-header">
                        <h5>Tambah Produk</h5>
                        <button class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">

                        <input type="text" name="name" class="form-control mb-2" placeholder="Nama">

                        <textarea name="description" class="form-control mb-2" placeholder="Deskripsi"></textarea>

                        <input type="number" name="price" class="form-control mb-2" placeholder="Harga">

                        <input type="number" name="stock" class="form-control mb-2" placeholder="Stok">

                        <!-- TAMBAHAN GAMBAR -->
                        <label class="form-label">Gambar Produk</label>
                        <input type="file" name="image" class="form-control mb-2" accept="image/*">

                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button class="btn btn-primary">Simpan</button>
                    </div>

                </form>

            </div>
        </div>
    </div>

@endsection
