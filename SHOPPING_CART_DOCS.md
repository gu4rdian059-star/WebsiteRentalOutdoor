# 🛒 Dokumentasi Sistem Shopping Cart - Persewaan Alat Outdoor

## 📋 Ringkasan Fitur yang Ditambahkan

Saya telah mengimplementasikan sistem **Shopping Cart lengkap** untuk aplikasi persewaan alat outdoor Anda dengan fitur-fitur berikut:

---

## ✨ Fitur-Fitur Utama

### 1. **Menu Keranjang di Navbar** 🛒
- **Lokasi**: Navbar di setiap halaman (app.blade.php)
- **Icon**: 🛒 Cart dengan badge merah menunjukkan jumlah item
- **Fungsi**: Menampilkan jumlah alat yang ada di keranjang secara real-time
- Klik untuk masuk ke halaman keranjang

### 2. **Tombol Tambah ke Keranjang** (Home Page)
- **Perubahan**: Button "Sewa Sekarang" di setiap kartu alat membuka modal untuk memilih tanggal
- **Modal Form**:
  - ✅ Nama alat (readonly)
  - ✅ Harga per hari (readonly)
  - ✅ Tanggal Sewa (date picker)
  - ✅ Tanggal Kembali (date picker)
  - ✅ **Jumlah Hari** (auto-calculated)
  - ✅ **Subtotal** (auto-calculated)
- **Fitur Khusus**:
  - Perhitungan otomatis jumlah hari (selisih + 1)
  - Perhitungan otomatis total harga (hari × harga/hari)
  - Validasi tanggal kembali ≥ tanggal sewa
  - Minimum 1 hari penyewaan

### 3. **Halaman Keranjang** 🛒
- **Route**: `GET /cart` → `route('cart.index')`
- **File**: `resources/views/cart/index.blade.php`
- **Fitur**:
  - ✅ Tampilan semua item di keranjang dengan detail lengkap
  - ✅ Gambar alat, nama, kategori
  - ✅ Tanggal sewa & kembali
  - ✅ Jumlah hari penyewaan
  - ✅ Harga per hari & subtotal
  - ✅ Tombol hapus item individual
  - ✅ Ringkasan total pembayaran
  - ✅ Tombol "Lanjut Berbelanja" (kembali ke home)
  - ✅ Tombol "Lanjut ke Checkout"
  - ✅ Tombol "Kosongkan Keranjang"
  - ✅ Pesan ketika keranjang kosong

### 4. **Halaman Checkout** ✅
- **Route**: `GET /cart/checkout` → `route('cart.checkout')`
- **File**: `resources/views/cart/checkout.blade.php`
- **Layout**: 2 kolom responsive
  - **Kiri**: Detail pesanan + Form data penyewa
  - **Kanan**: Ringkasan pembayaran (sticky position)
- **Form Input**:
  - ✅ Nama Lengkap
  - ✅ Email
  - ✅ Nomor Telepon
  - ✅ Alamat Lengkap
  - ✅ Metode Pembayaran (Transfer Bank / E-Wallet)
- **Info ditampilkan**:
  - ✅ Semua item yang akan dibeli
  - ✅ Tanggal sewa & kembali
  - ✅ Jumlah hari & harga per hari
  - ✅ Subtotal untuk setiap item
  - ✅ Total keseluruhan pembayaran
  - ✅ Jumlah alat & total hari penyewaan

### 5. **Cart Controller** (Backend Logic)
- **File**: `app/Http/Controllers/CartController.php`
- **Methods**:
  - `index()` - Tampil keranjang
  - `add()` - Tambah item ke keranjang (AJAX/JSON)
  - `remove()` - Hapus item dari keranjang
  - `clear()` - Kosongkan semua keranjang
  - `checkout()` - Redirect ke halaman checkout

**Penyimpanan**: Session-based (tidak perlu database untuk cart items)
**Key Format**: `{id_alat}_{tgl_sewa}_{tgl_kembali}` - Memungkinkan alat sama dengan tanggal berbeda

### 6. **Otomasi Perhitungan Hari** 🧮
#### Di Frontend (Home):
```javascript
jumlahHari = Math.ceil((tglKembali - tglSewa) / (1000 * 60 * 60 * 24)) + 1
totalHarga = jumlahHari × hargaSewa
```

#### Di Backend (CartController):
```php
$jumlahHari = ceil(($tglKembali - $tglSewa) / 86400) + 1;
$subtotal = $jumlahHari × $alat->harga_sewa;
```

#### Di Backend (TransaksiSewaController - storeFromCheckout):
```php
$calculatedDays = $tglKembali->diffInDays($tglSewa) + 1;
$itemTotal = $calculatedDays × $alat->harga_sewa;
```

**Konsistensi**: Backend selalu recalculate dari tanggal untuk memastikan akurasi

### 7. **Transaksi Checkout Multiple Items**
- **New Method**: `storeFromCheckout()` di TransaksiSewaController
- **Fitur**:
  - ✅ Membuat 1 pelanggan baru untuk group transaksi
  - ✅ Membuat N transaksi (1 per alat)
  - ✅ Setiap transaksi dihitung hari secara terpisah
  - ✅ Total harga dihitung dengan benar (bukan jumlah subtotal, tapi recalculated)
  - ✅ Clear cart otomatis setelah sukses
  - ✅ Redirect ke transaksi_sewa.index dengan pesan sukses

### 8. **Session Management**
- **Key**: `cart`
- **Format**:
```php
$cart = [
    '{id_alat}_{tgl_sewa}_{tgl_kembali}' => [
        'id_alat' => int,
        'nama_alat' => string,
        'kategori' => string,
        'gambar' => string,
        'harga_sewa' => int,
        'tgl_sewa' => string (Y-m-d),
        'tgl_kembali' => string (Y-m-d),
        'jumlah_hari' => int,
        'subtotal' => int,
    ],
    ...
]
```

---

## 🔄 Alur Penggunaan

### User Flow:
1. **Home Page** → Lihat daftar alat
2. **Klik "Sewa Sekarang"** → Modal terbuka
3. **Pilih Tanggal** → Auto-hitung hari & harga
4. **Klik "Tambah ke Keranjang"** → Item ditambahkan (reload page)
5. **Repeat** → Tambah alat lain (bisa 1, 2, 3, atau lebih alat)
6. **Klik Icon Keranjang** (navbar) → Lihat semua item
7. **Review Cart** → Lihat detail setiap item & total
8. **Klik "Lanjut ke Checkout"** → Ke form pembayaran
9. **Isi Form** → Data penyewa & metode pembayaran
10. **Submit** → Transaksi dibuat + Cart dikosongkan
11. **Redirect** → Ke halaman Transaksi Sewa dengan pesan sukses

---

## 📁 File-File yang Dibuat/Dimodifikasi

### ✅ File Baru:
- `app/Http/Controllers/CartController.php` - Controller cart logic
- `resources/views/cart/index.blade.php` - Halaman keranjang
- `resources/views/cart/checkout.blade.php` - Halaman checkout

### ✅ File Dimodifikasi:
- `routes/web.php` - Tambah routes untuk cart
- `app/Http/Controllers/TransaksiSewaController.php` - Tambah storeFromCheckout method
- `resources/views/Layouts/app.blade.php` - Tambah cart icon di navbar
- `resources/views/home.blade.php` - Update modal & button ke cart system

---

## 🎨 Design & UI

### Styling Features:
- **Gradients**: Modern gradient backgrounds (green theme #1e8e5a → #28c76f)
- **Animations**: Fade-in up animations pada halaman muat
- **Responsive**: Mobile-first design, fully responsive
- **Icons**: Bootstrap Icons digunakan di semua tempat
- **Cards**: Hover effects & smooth transitions

### Color Scheme:
- **Primary**: #1e8e5a (Green - Main color)
- **Secondary**: #28c76f (Light Green)
- **Light BG**: #f8fafb, #f0f7f4
- **Text**: #2c3e50 (Dark), #7f8c8d (Gray)
- **Danger**: #ff6b6b (Red for remove buttons)

---

## ⚙️ Validasi & Error Handling

### Frontend:
- ✅ Modal validation sebelum submit
- ✅ Tanggal validation (kembali ≥ sewa)
- ✅ Alert user-friendly

### Backend:
- ✅ Validate cart data exists
- ✅ Validate tanggal format
- ✅ Validate alat ada di database
- ✅ Recalculate hari untuk consistency
- ✅ Handle empty cart

---

## 📊 Database Usage

### Tables Digunakan:
- `transaksi_sewas` - Simpan transaksi individual
- `pelanggans` - Buat pelanggan baru saat checkout
- `alats` - Fetch info alat

### Tidak Perlu Migration:
- Cart items disimpan di **session**, bukan database
- Lebih cepat & lebih efisien untuk temporary data

---

## 🔐 Security

- ✅ CSRF token di form checkout
- ✅ Validation semua input
- ✅ Auth check (implicit via session)
- ✅ Recalculate price di backend (tidak percaya frontend)

---

## 🚀 Testing Checklist

- [ ] Tambah 1 alat → Keranjang terupdate
- [ ] Tambah alat berbeda → Semua ada di keranjang
- [ ] Tambah alat yang sama dengan tanggal berbeda → Separate item
- [ ] Hapus item → Item hilang, jumlah berkurang
- [ ] Kosongkan keranjang → Semua item hilang
- [ ] Checkout → Transaksi berhasil dibuat
- [ ] Verify hari calculation → 2 hari = 2 hari (bukan 1)
- [ ] Verify harga → (hari × harga_sewa) benar
- [ ] Mobile responsive → Keranjang tampil baik di HP

---

## 💡 Tips Penggunaan

1. **Total Hari Calculation**: Sistem menghitung hari dengan formula `(tglKembali - tglSewa) + 1`
   - Contoh: 5 Feb - 3 Feb = 2 hari + 1 = **3 hari** ✅

2. **Multiple Items**: Setiap item dihitung jumlah harinya sendiri
   - Item 1: 3 hari × Rp 100k = Rp 300k
   - Item 2: 5 hari × Rp 50k = Rp 250k
   - **Total: Rp 550k** ✅

3. **Session Based**: Cart data hilang jika user logout/clear cookies
   - Reminder: Arahkan user checkout sebelum menutup browser

4. **No Minimum Day**: Sistem support penyewaan 1 hari saja

---

## 📞 Support

Jika ada pertanyaan atau bug, silakan hubungi!

---

**Status**: ✅ Selesai dan Ready to Use
**Terakhir Update**: 5 Februari 2026
