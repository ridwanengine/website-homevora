@extends('layouts.admin')

@section('content')
    <div class="container">

        <h3>Edit Metode Pembayaran</h3>

        <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editModal{{ $item->id }}">

            Edit

        </button>
        @csrf
        @method('PUT')

        <div class="mb-3">

            <label>Nama</label>

            <input type="text" name="name" class="form-control" value="{{ $payment->name }}">

        </div>


        <div class="mb-3">

            <label>No Rek</label>

            <input type="text" name="account_number" class="form-control" value="{{ $payment->account_number }}">

        </div>


        <div class="mb-3">

            <label>Atas Nama</label>

            <input type="text" name="account_name" class="form-control" value="{{ $payment->account_name }}">

        </div>


        <button class="btn btn-primary">

            Update

        </button>

        </form>

    </div>
@endsection
