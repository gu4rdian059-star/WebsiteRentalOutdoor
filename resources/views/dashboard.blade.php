@extends('layouts.app')

@section('content')
<div class="container mt-4">

    <h2 class="fw-bold">Dashboard</h2>
    <p class="text-muted">
        Selamat datang, <b>{{ auth()->user()->name }}</b>
    </p>

    <div class="row mt-4">
        <div class="col-md-3">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <h5>Pelanggan</h5>
                    <a href="{{ route('pelanggan.index') }}" class="btn btn-primary btn-sm mt-2">
                        Kelola
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <h5>Alat</h5>
                    <a href="{{ route('alat.index') }}" class="btn btn-success btn-sm mt-2">
                        Kelola
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <h5>Transaksi</h5>
                    <a href="{{ route('transaksi_sewa.index') }}" class="btn btn-warning btn-sm mt-2">
                        Kelola
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <h5>Denda</h5>
                    <a href="{{ route('denda.index') }}" class="btn btn-danger btn-sm mt-2">
                        Kelola
                    </a>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
