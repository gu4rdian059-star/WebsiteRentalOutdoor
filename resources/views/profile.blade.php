@extends('layouts.app')

@section('title', 'Profil')

@section('content')
<div class="container">
    <div class="card shadow-sm rounded-4">
        <div class="card-body">

            <h4 class="mb-4 fw-bold">Profil Saya</h4>

            <div class="mb-3">
                <label class="form-label fw-semibold">Nama</label>
                <input type="text" class="form-control" value="{{ $user->name }}" readonly>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Email</label>
                <input type="text" class="form-control" value="{{ $user->email }}" readonly>
            </div>

            @if($pelanggan)
                <hr>
                <h6 class="fw-bold">Data Pelanggan</h6>

                <div class="mb-2">
                    <strong>Nama Pelanggan:</strong> {{ $pelanggan->nama_pelanggan }}
                </div>

                <div class="mb-2">
                    <strong>No HP:</strong> {{ $pelanggan->no_hp ?? '-' }}
                </div>
            @else
                <div class="alert alert-warning mt-3">
                    Data pelanggan belum tersedia.
                </div>
            @endif

        </div>
    </div>
</div>
@endsection
