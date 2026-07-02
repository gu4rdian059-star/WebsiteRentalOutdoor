@extends('layouts.app')
@section('title', $alat->nama_alat)

@section('content')
<div class="container py-5">
    <div class="row g-4">
        <div class="col-lg-6">
            <div class="card border-0 shadow rounded-4 overflow-hidden">
                @if($alat->gambar)
                    <img src="{{ asset('images/alat/'.$alat->gambar) }}" class="w-100" style="height:420px; object-fit:cover;" alt="{{ $alat->nama_alat }}">
                @else
                    <div style="height:420px; background:#f0f0f0; display:flex; align-items:center; justify-content:center;">
                        <i class="bi bi-image" style="font-size:4rem; color:#ccc;"></i>
                    </div>
                @endif
            </div>
        </div>

        <div class="col-lg-6">
            <h2 class="fw-bold">{{ $alat->nama_alat }}</h2>
            <div class="mb-3">
                <span class="badge bg-success-subtle text-success px-3">{{ $alat->kategori ?? 'Outdoor' }}</span>
                <span class="ms-2 text-muted">📦 Stok: <strong class="text-success">{{ $alat->stok }}</strong></span>
            </div>

            <div class="mb-4">
                <h3 class="text-success">
                    Rp {{ number_format($alat->harga_sewa,0,',','.') }}
                    <small class="text-muted">/hari</small>
                </h3>
            </div>

            <p class="text-muted">{{ $alat->deskripsi ?? 'Belum ada deskripsi untuk alat ini.' }}</p>

            <div class="mt-4 d-flex gap-3">
                @if($alat->stok > 0)
                    <button class="btn btn-success btn-lg rounded-pill" id="btnSewaNow">
                        🛒 Sewa Sekarang
                    </button>
                @else
                    <button class="btn btn-secondary btn-lg rounded-pill" disabled>Stok Habis</button>
                @endif

                <a href="{{ route('alat.index') }}" class="btn btn-outline-secondary btn-lg rounded-pill">
                    Kembali
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

@section('modals')
<div class="modal fade" id="modalSewaShow" tabindex="-1">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header" style="background:linear-gradient(135deg,#1e8e5a,#28c76f); color:#fff;">
                <h5 class="modal-title">🎒 Sewa Alat: {{ $alat->nama_alat }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                {{-- ⬇️ FORM LANGSUNG KE CHECKOUT --}}
                <form action="{{ route('cart.sewaSekarang') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id_alat" value="{{ $alat->id_alat }}">

                    <div class="mb-3">
                        <label class="form-label">📅 Tanggal Sewa</label>
                        <input type="date" class="form-control" id="tglSewaShow" name="tgl_sewa" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">📅 Tanggal Kembali</label>
                        <input type="date" class="form-control" id="tglKembaliShow" name="tgl_kembali" required>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <label class="form-label">📊 Jumlah Hari</label>
                            <input type="number" class="form-control" id="jumlahHariShow" disabled>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">💵 Subtotal</label>
                            <input type="text" class="form-control fw-bold text-success" id="totalHargaShow" disabled>
                        </div>
                    </div>

                    <div class="mt-4 text-end">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success">
                            Lanjut ke Checkout
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.getElementById('btnSewaNow')?.addEventListener('click', function(){
    const today = new Date().toISOString().split('T')[0];
    document.getElementById('tglSewaShow').min = today;
    document.getElementById('tglKembaliShow').min = today;
    new bootstrap.Modal(document.getElementById('modalSewaShow')).show();
});

function calculateShow(){
    const s = document.getElementById('tglSewaShow').value;
    const k = document.getElementById('tglKembaliShow').value;
    if(!s || !k) return;

    const ds = new Date(s);
    const dk = new Date(k);
    if(dk < ds){
        alert('Tanggal kembali tidak boleh sebelum tanggal sewa');
        document.getElementById('tglKembaliShow').value = '';
        return;
    }

    const hari = Math.ceil((dk - ds)/(1000*60*60*24)) + 1;
    const total = hari * {{ $alat->harga_sewa }};
    document.getElementById('jumlahHariShow').value = hari;
    document.getElementById('totalHargaShow').value =
        'Rp ' + new Intl.NumberFormat('id-ID').format(total);
}

document.getElementById('tglSewaShow')?.addEventListener('change', calculateShow);
document.getElementById('tglKembaliShow')?.addEventListener('change', calculateShow);
</script>
@endsection
