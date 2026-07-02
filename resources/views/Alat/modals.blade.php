{{-- MODAL DETAIL ALAT (PREMIUM SPLIT DESIGN) --}}
<div class="modal fade" id="modalDetail" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content border-0 overflow-hidden shadow-2xl" style="border-radius: 32px;">
            <div class="modal-body p-0">
                <div class="row g-0">
                    {{-- LEFT: VISUAL (Large Image) --}}
                    <div class="col-lg-6 position-relative bg-light">
                        <img id="detailAlatGambar" src="" class="w-100 h-100" style="object-fit: cover; min-height: 500px;" alt="Product image">
                        <div class="position-absolute top-0 start-0 p-4">
                            <span class="badge bg-white text-dark shadow-sm px-3 py-2 rounded-pill fw-800" id="detailAlatKategori" style="font-size: 0.75rem; letter-spacing: 1px; text-transform: uppercase;"></span>
                        </div>
                        <button type="button" class="btn-close btn-close-white position-absolute top-0 end-0 m-4 shadow-lg p-3 bg-dark opacity-100 rounded-circle" data-bs-dismiss="modal" style="--bs-btn-close-bg: url('data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 16 16%22 fill=%22%23fff%22%3E%3Cpath d=%22M.293.293a1 1 0 011.414 0L8 6.586 14.293.293a1 1 0 111.414 1.414L9.414 8l6.293 6.293a1 1 0 01-1.414 1.414L8 9.414l-6.293 6.293a1 1 0 01-1.414-1.414L6.586 8 .293 1.707a1 1 0 010-1.414z%22/%3E%3C/svg%3E'); background-size: 12px;"></button>
                    </div>

                    {{-- RIGHT: CONTENT (Details & Actions) --}}
                    <div class="col-lg-6 p-5 d-flex flex-column justify-content-center bg-white">
                        <div class="mb-4">
                            <small class="text-primary fw-bold mb-2 d-block" id="detailAlatKat2" style="letter-spacing: 2px; text-transform: uppercase; font-size: 0.7rem;"></small>
                            <h2 class="fw-900 text-dark mb-1" id="detailAlatNama" style="font-size: 2.5rem; letter-spacing: -1px;"></h2>
                            <p class="text-muted fs-5 mb-0" id="detailAlatMerk"></p>
                        </div>

                        <div class="d-flex align-items-center gap-4 mb-4">
                            <div class="price-tag">
                                <span class="text-muted small d-block fw-bold">HARGA SEWA</span>
                                <h3 class="text-success fw-900 mb-0" id="detailAlatHarga"></h3>
                                <small class="text-muted">per hari</small>
                            </div>
                            <div class="vr mx-2 text-slate-200"></div>
                            <div class="stock-info">
                                <span class="text-muted small d-block fw-bold">KETERSEDIAAN</span>
                                <div id="detailStokBadge" class="fw-800 fs-5 mt-1"></div>
                            </div>
                        </div>

                        <div class="description-section mb-4">
                            <h6 class="fw-800 text-dark text-uppercase small mb-2" style="letter-spacing: 1px;">Tentang Alat</h6>
                            <p id="detailAlatDeskripsi" class="text-secondary" style="line-height: 1.7; font-size: 0.95rem;"></p>
                            
                            <h6 class="fw-800 text-dark text-uppercase small mb-2 mt-3" style="letter-spacing: 1px;">Kegunaan Utama</h6>
                            <p id="detailAlatKegunaan" class="text-secondary" style="line-height: 1.7; font-size: 0.95rem;"></p>
                        </div>

                        {{-- ACTIONS --}}
                        <div class="mt-auto">
                            <div class="d-flex align-items-center gap-3 mb-4">
                                <span class="fw-bold text-dark">Jumlah:</span>
                                <div class="input-group rounded-pill overflow-hidden border" style="width: 140px; height: 45px;">
                                    <button class="btn btn-light border-0 px-3" type="button" id="detailQtyMinus"><i class="bi bi-dash"></i></button>
                                    <input type="number" class="form-control border-0 text-center fw-800 bg-white" id="detailQuantity" value="1" min="1" readonly>
                                    <button class="btn btn-light border-0 px-3" type="button" id="detailQtyPlus"><i class="bi bi-plus"></i></button>
                                </div>
                            </div>

                            <div class="row g-3">
                                <div class="col-sm-6">
                                    <button type="button" class="btn btn-outline-dark w-100 py-3 rounded-4 fw-800 transition-all hover-up" id="detailBtnCart" style="border-width: 2px;">
                                        <i class="bi bi-cart3 me-2"></i> Keranjang
                                    </button>
                                </div>
                                <div class="col-sm-6">
                                    <button type="button" class="btn btn-primary w-100 py-3 rounded-4 fw-800 shadow-lg transition-all hover-up border-0" id="detailBtnCheckout" style="background: #10b981;">
                                        <i class="bi bi-lightning-fill me-2"></i> Sewa Sekarang
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- MODAL FORM SEWA (MODERN BOOKING STYLE) --}}
<div class="modal fade" id="modalSewa" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content border-0 shadow-2xl" style="border-radius: 28px;">
            <div class="modal-header border-0 p-4 pb-0">
                <h5 class="modal-title fw-900 text-dark" style="font-size: 1.5rem; letter-spacing: -0.5px;">Konfirmasi Pesanan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <div class="p-3 mb-4 rounded-4 d-flex align-items-center gap-3" style="background: rgba(16, 185, 129, 0.05); border: 1px solid rgba(16, 185, 129, 0.1);">
                    <div class="bg-primary text-white rounded-3 shadow-sm d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; font-size: 1.5rem;">
                        🎒
                    </div>
                    <div>
                        <h6 class="fw-800 mb-0 text-dark" id="namaAlatModal"></h6>
                        <small class="text-muted" id="hargaAlatInputText"></small>
                    </div>
                </div>

                <form id="formSewa">
                    @csrf
                    <input type="hidden" id="idAlatHidden" name="id_alat">
                    <input type="hidden" id="modeHidden" name="mode" value="cart">
                    <input type="hidden" id="quantityInput" name="quantity" value="1">
                    <input type="hidden" id="jumlahHariHidden" name="jumlah_hari">

                    <div class="row g-3">
                        <div class="col-6">
                            <label class="form-label fw-800 small text-uppercase text-muted">Tanggal Sewa</label>
                            <input type="date" class="form-control py-3 rounded-3 border-light shadow-sm bg-light" id="tglSewa" name="tgl_sewa" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label fw-800 small text-uppercase text-muted">Tanggal Kembali</label>
                            <input type="date" class="form-control py-3 rounded-3 border-light shadow-sm bg-light" id="tglKembali" name="tgl_kembali" required>
                        </div>
                    </div>

                    {{-- SUMMARY CARD --}}
                    <div class="mt-4 p-4 rounded-4 shadow-sm position-relative overflow-hidden" style="background: #1e293b; border: 1px solid rgba(255,255,255,0.05);">
                        {{-- Subtle background glow --}}
                        <div class="position-absolute bottom-0 end-0 bg-primary opacity-10 rounded-circle" style="width: 150px; height: 150px; transform: translate(30%, 30%); filter: blur(40px);"></div>
                        
                        <div class="row align-items-center position-relative z-1">
                            <div class="col-7">
                                <div class="mb-2">
                                    <span class="text-white opacity-50 small fw-bold text-uppercase" style="letter-spacing: 1px;">Pesanan Anda</span>
                                    <h6 class="text-white fw-800 mb-0 mt-1">
                                        <span id="displayQty">1</span> Unit × <span id="jumlahHari">0</span> Hari
                                    </h6>
                                </div>
                                <div>
                                    <span class="text-white opacity-50 small fw-bold text-uppercase" style="letter-spacing: 1px;">Total Estimasi</span>
                                    <h3 class="text-success fw-900 mb-0 mt-1" id="totalHarga" style="font-size: 1.8rem;">Rp 0</h3>
                                </div>
                            </div>
                            <div class="col-5 text-end">
                                <div class="mb-2">
                                    <i class="bi bi-wallet2 text-white opacity-25" style="font-size: 2.5rem;"></i>
                                </div>
                                <span class="badge bg-success shadow-box px-3 py-2 rounded-pill fw-bold" style="font-size: 0.75rem;">Lunas di Tempat</span>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4">
                        <button type="button" id="btnAksi" class="btn btn-success w-100 py-3 rounded-4 fw-800 shadow-sm transition-all hover-up" style="background: #10b981; border:none; font-size: 1.1rem;">
                            Konfirmasi Penyewaan
                        </button>
                        <button type="button" class="btn btn-link w-100 mt-2 text-muted text-decoration-none fw-bold small" data-bs-dismiss="modal">Batalkan Pesanan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
.fw-800 { font-weight: 800; }
.fw-900 { font-weight: 900; }
.shadow-2xl { box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25); }
.hover-up:hover { transform: translateY(-3px); }
.transition-all { transition: all 0.3s ease; }
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const isLoggedIn = {{ Auth::check() ? 'true' : 'false' }};
    let currentAlatData = null;

    // Handle Detail Modal (Grid Cards)
    document.querySelectorAll('.btn-detail-alat').forEach(card => {
        card.addEventListener('click', function(e) {
            const data = this.dataset;
            currentAlatData = { ...data, quantity: 1 };
            
            document.getElementById('detailAlatNama').textContent = data.nama;
            document.getElementById('detailAlatKategori').textContent = data.kategori;
            document.getElementById('detailAlatKat2').textContent = data.kategori;
            document.getElementById('detailAlatMerk').textContent = data.merk || 'No Brand Info';
            document.getElementById('detailAlatHarga').textContent = 'Rp ' + Number(data.harga).toLocaleString('id-ID');
            document.getElementById('detailAlatDeskripsi').textContent = data.deskripsi || 'Nikmati petualangan Anda dengan peralatan berkualitas tinggi kami.';
            document.getElementById('detailAlatKegunaan').textContent = data.kegunaan || 'Ideal untuk pendakian, camping, dan berbagai aktivitas outdoor lainnya.';
            document.getElementById('detailAlatGambar').src = data.gambar;
            document.getElementById('detailQuantity').value = 1;
            
            const stok = parseInt(data.stok);
            const badge = document.getElementById('detailStokBadge');
            if (stok > 0) {
                badge.innerHTML = `<span class="text-success"><i class="bi bi-check-circle-fill me-2"></i>Tersedia (${stok} unit)</span>`;
            } else {
                badge.innerHTML = `<span class="text-danger"><i class="bi bi-x-circle-fill me-2"></i>Stok Habis</span>`;
            }
            
            document.getElementById('detailBtnCart').disabled = stok <= 0;
            document.getElementById('detailBtnCheckout').disabled = stok <= 0;

            const modalDetail = new bootstrap.Modal(document.getElementById('modalDetail'));
            modalDetail.show();
        });
    });

    // Quantity Detail Modal
    document.getElementById('detailQtyMinus')?.addEventListener('click', () => {
        const input = document.getElementById('detailQuantity');
        if (input.value > 1) {
            input.value--;
            currentAlatData.quantity = input.value;
        }
    });
    document.getElementById('detailQtyPlus')?.addEventListener('click', () => {
        const input = document.getElementById('detailQuantity');
        // Optional: limit to stock
        if (parseInt(input.value) < parseInt(currentAlatData.stok)) {
            input.value++;
            currentAlatData.quantity = input.value;
        } else {
            alert('Maksimal stok tersedia adalah ' + currentAlatData.stok);
        }
    });

    // Handle Buttons in Detail Modal
    document.getElementById('detailBtnCart')?.addEventListener('click', () => openSewaModal('cart'));
    document.getElementById('detailBtnCheckout')?.addEventListener('click', () => openSewaModal('checkout'));

    function openSewaModal(mode) {
        if (!isLoggedIn) {
            window.location.href = "{{ route('login') }}";
            return;
        }

        const modalDetail = bootstrap.Modal.getInstance(document.getElementById('modalDetail'));
        if (modalDetail) modalDetail.hide();

        document.getElementById('idAlatHidden').value = currentAlatData.id;
        document.getElementById('modeHidden').value = mode;
        document.getElementById('namaAlatModal').textContent = currentAlatData.nama;
        document.getElementById('hargaAlatInputText').textContent = 'Rp ' + Number(currentAlatData.harga).toLocaleString('id-ID') + ' / hari';
        document.getElementById('displayQty').textContent = currentAlatData.quantity;
        document.getElementById('quantityInput').value = currentAlatData.quantity;
        
        document.getElementById('btnAksi').innerHTML = mode === 'cart' ? '<i class="bi bi-cart-plus me-2"></i>Masukkan ke Keranjang' : '<i class="bi bi-lightning-charge me-2"></i>Lanjut Checkout';

        setTimeout(() => {
            const modalSewa = new bootstrap.Modal(document.getElementById('modalSewa'));
            modalSewa.show();
        }, 400);
    }

    // Calculation Logic for Sewa Modal
    function calculateTotal() {
        const start = document.getElementById('tglSewa').value;
        const end = document.getElementById('tglKembali').value;
        const qty = parseInt(document.getElementById('quantityInput').value);
        const price = parseInt(currentAlatData.harga);

        if (start && end) {
            const d1 = new Date(start);
            const d2 = new Date(end);
            
            d1.setHours(0,0,0,0);
            d2.setHours(0,0,0,0);

            if (d2 < d1) {
                alert('Tanggal kembali tidak boleh sebelum tanggal sewa');
                document.getElementById('tglKembali').value = '';
                return;
            }

            const diffTime = Math.abs(d2 - d1);
            const days = Math.ceil(diffTime / (1000 * 60 * 60 * 24)) + 1;
            const total = price * days * qty;
            
            document.getElementById('jumlahHari').textContent = days;
            document.getElementById('jumlahHariHidden').value = days;
            document.getElementById('totalHarga').textContent = 'Rp ' + total.toLocaleString('id-ID');
        }
    }

    document.getElementById('tglSewa')?.addEventListener('change', calculateTotal);
    document.getElementById('tglKembali')?.addEventListener('change', calculateTotal);

    // Final Action
    document.getElementById('btnAksi')?.addEventListener('click', function() {
        const mode = document.getElementById('modeHidden').value;
        const form = document.getElementById('formSewa');
        const formData = new FormData(form);

        if (!formData.get('tgl_sewa') || !formData.get('tgl_kembali')) {
            alert('Harap tentukan tanggal sewa dan kembali dengan teliti.');
            return;
        }

        if (mode === 'cart') {
            fetch("{{ route('cart.add') }}", {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    "Accept": "application/json",
                    "Content-Type": "application/json"
                },
                body: JSON.stringify(Object.fromEntries(formData))
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    alert('✅ ' + data.message);
                    location.reload();
                } else {
                    alert('❌ ' + data.message);
                }
            });
        } else {
            const params = new URLSearchParams(formData).toString();
            window.location.href = "{{ route('cart.checkout') }}?" + params;
        }
    });
});
</script>
