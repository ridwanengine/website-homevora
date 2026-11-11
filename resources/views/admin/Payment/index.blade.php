@extends('layouts.admin')

@section('title', 'Metode Pembayaran')

@section('page-title', 'Metode Pembayaran')

@section('content')
    <div class="container">

        <div class="d-flex justify-content-between mb-3">
            <h3>Metode Pembayaran</h3>

            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#tambahModal">
                Tambah
            </button>
        </div>

        {{-- Alert --}}
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        {{-- Tabel --}}
        <div class="card">
            <div class="card-body">

                <table class="table table-bordered table-striped">

                    <thead class="table-dark">
                        <tr>
                            <th width="60">No</th>
                            <th>Nama</th>
                            <th>No Rekening</th>
                            <th>Atas Nama</th>
                            <th width="180">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse($payments as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->account_number }}</td>
                                <td>{{ $item->account_name }}</td>

                                <td>

                                    <button class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#editModal{{ $item->id }}">
                                        Edit
                                    </button>

                                    <form action="{{ route('admin.payment.destroy', $item->id) }}" method="POST"
                                        class="d-inline" onsubmit="return confirm('Yakin ingin menghapus data ini?')">

                                        @csrf
                                        @method('DELETE')

                                        <button class="btn btn-danger btn-sm">
                                            Hapus
                                        </button>

                                    </form>

                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td colspan="5" class="text-center">
                                    Belum ada metode pembayaran.
                                </td>
                            </tr>
                        @endforelse

                    </tbody>

                </table>

            </div>
        </div>

    </div>

    {{-- ========================= --}}
    {{-- MODAL TAMBAH --}}
    {{-- ========================= --}}
    <div class="modal fade" id="tambahModal" tabindex="-1">

        <div class="modal-dialog">

            <div class="modal-content">

                <form action="{{ route('admin.payment.store') }}" method="POST">

                    @csrf

                    <div class="modal-header">
                        <h5 class="modal-title">
                            Tambah Metode Pembayaran
                        </h5>

                        <button type="button" class="btn-close" data-bs-dismiss="modal">
                        </button>
                    </div>

                    <div class="modal-body">

                        <div class="mb-3">
                            <label class="form-label">Nama</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">No Rekening</label>
                            <input type="text" name="account_number" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Atas Nama</label>
                            <input type="text" name="account_name" class="form-control" required>
                        </div>

                    </div>

                    <div class="modal-footer">

                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            Batal
                        </button>

                        <button type="submit" class="btn btn-success">
                            Simpan
                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

    {{-- Modal Edit --}}
    @foreach ($payments as $item)
        <div class="modal fade" id="editModal{{ $item->id }}" tabindex="-1">

            <div class="modal-dialog">

                <div class="modal-content">

                    <form action="{{ route('admin.payment.update', $item->id) }}" method="POST">

                        @csrf
                        @method('PUT')

                        <div class="modal-header">

                            <h5 class="modal-title">
                                Edit Metode Pembayaran
                            </h5>

                            <button type="button" class="btn-close" data-bs-dismiss="modal">
                            </button>

                        </div>

                        <div class="modal-body">

                            <div class="mb-3">
                                <label class="form-label">Nama</label>
                                <input type="text" name="name" class="form-control" value="{{ $item->name }}"
                                    required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">No Rekening</label>
                                <input type="text" name="account_number" class="form-control"
                                    value="{{ $item->account_number }}" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Atas Nama</label>
                                <input type="text" name="account_name" class="form-control"
                                    value="{{ $item->account_name }}" required>
                            </div>

                        </div>

                        <div class="modal-footer">

                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                Batal
                            </button>

                            <button type="submit" class="btn btn-primary">
                                Update
                            </button>

                        </div>

                    </form>

                </div>

            </div>

        </div>
    @endforeach

@endsection
