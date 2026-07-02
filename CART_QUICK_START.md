# 🎯 Quick Start Guide - Shopping Cart System

## 🚀 Mulai Menggunakan Dalam 5 Menit

### Step 1: Login ke Aplikasi
```
URL: http://localhost/PersewaanAlatApp
Login dengan akun Penyewa (bukan Admin)
```

### Step 2: Lihat Halaman Home
```
✓ Di bagian bawah ada section "🎒 Sewa Alat"
✓ Terlihat kartu-kartu alat dengan:
  - Gambar alat
  - Nama alat
  - Kategori
  - Stok
  - Harga/hari
  - Button "🛒 Sewa Sekarang"
```

### Step 3: Tambah Alat ke Keranjang
```
1. Klik "🛒 Sewa Sekarang" pada salah satu alat
2. Modal dialog terbuka dengan form:
   ┌─────────────────────────────────────┐
   │ 🎒 Sewa Alat: [Nama Alat]          │
   ├─────────────────────────────────────┤
   │ 📦 Nama Alat: [Readonly]            │
   │ 💰 Harga Per Hari: [Readonly]       │
   │ 📅 Tanggal Sewa: [Date Picker]      │
   │ 📅 Tanggal Kembali: [Date Picker]   │
   │ 📊 Jumlah Hari: [Auto-filled]       │
   │ 💵 Subtotal: [Auto-filled]          │
   │                                     │
   │ [Batal] [✅ Tambah ke Keranjang]   │
   └─────────────────────────────────────┘

3. Pilih tanggal sewa (misal: 5 Feb)
4. Pilih tanggal kembali (misal: 8 Feb)
5. Sistem otomatis menghitung: 8 Feb - 5 Feb + 1 = 4 hari
6. Sistem otomatis hitung: Subtotal = 4 × harga/hari
7. Klik "✅ Tambah ke Keranjang"
8. Page reload, item berhasil ditambahkan ✅
```

### Step 4: Lihat Keranjang
```
1. Perhatikan navbar di atas → ada icon 🛒 dengan angka merah
2. Angka menunjukkan jumlah item (misal: 🛒 1)
3. Klik icon 🛒
4. Dibawa ke halaman keranjang: /cart

Halaman Keranjang menampilkan:
┌──────────────────────────────────────────────────────┐
│ 🛒 Keranjang Sewa Anda                              │
│ 1 alat dalam keranjang                               │
├──────────────────────────────────────────────────────┤
│                                                      │
│ [Gambar] Nama Alat                                   │
│          🎒 Kategori                                 │
│          📅 5 Feb → 8 Feb                           │
│          📊 4 hari × Rp 50,000/hari                 │
│          Subtotal: Rp 200,000   [🗑️ Hapus]         │
│                                                      │
├──────────────────────────────────────────────────────┤
│ Ringkasan Pembayaran:                               │
│ Subtotal         : Rp 200,000                       │
│ Pajak (0%)       : Rp 0                             │
│ ─────────────────────────────────                   │
│ Total Pembayaran : Rp 200,000                       │
├──────────────────────────────────────────────────────┤
│ [← Lanjut Berbelanja] [Lanjut ke Checkout →]       │
│ [🗑️ Kosongkan Keranjang]                            │
└──────────────────────────────────────────────────────┘
```

### Step 5: (Optional) Tambah Alat Lain
```
1. Klik [← Lanjut Berbelanja]
2. Kembali ke home
3. Klik "🛒 Sewa Sekarang" pada alat lain
4. Isi tanggal berbeda atau sama
5. Klik "✅ Tambah ke Keranjang"
6. Ulangi process
7. Keranjang sekarang punya 2+ item 🛒 2
```

### Step 6: Review & Checkout
```
1. Klik icon 🛒 di navbar
2. Lihat keranjang dengan 2-3 item
3. Pastikan semua benar
4. Klik [Lanjut ke Checkout →]
5. Dibawa ke halaman: /cart/checkout

Halaman Checkout:
┌─────────────────────────┬──────────────────────┐
│ Kiri (Form):            │ Kanan (Summary):     │
├─────────────────────────┼──────────────────────┤
│ Detail Pesanan:         │ Ringkasan Pembayaran:│
│ [Item 1 Preview]        │ Subtotal: Rp 200k    │
│ [Item 2 Preview]        │ Biaya: Rp 0          │
│                         │ Pajak: Rp 0          │
│ Informasi Penyewa:      │ ────────────────────│
│ 👤 Nama: [Input]        │ TOTAL: Rp 200,000   │
│ 📧 Email: [Input]       │                      │
│ 📱 Telepon: [Input]     │ [🔒 Checkout]       │
│ 📍 Alamat: [Textarea]   │                      │
│                         │ [← Kembali]         │
│ 💳 Metode Pembayaran:   │                      │
│ ○ 🏦 Transfer Bank      │                      │
│ ○ 📱 E-Wallet           │                      │
└─────────────────────────┴──────────────────────┘
```

### Step 7: Isi Form & Submit
```
1. Isi semua field:
   - Nama Lengkap: "Budi Santoso"
   - Email: "budi@gmail.com"
   - Telepon: "08xx-xxxx-xxxx"
   - Alamat: "Jl. Merdeka No. 123, Pasuruan"

2. Pilih metode pembayaran:
   - Pilih "🏦 Transfer Bank" atau "📱 E-Wallet"

3. Klik [🔒 Lanjut ke Pembayaran]
4. Form di-submit ke backend
5. Backend process:
   - Validasi semua input
   - Buat pelanggan baru
   - Buat transaksi untuk setiap item (dengan hari recalculate)
   - Clear cart session
   - Redirect ke /transaksi_sewa

6. Success message:
   "Checkout berhasil! 3 alat telah disewa dengan total Rp 550,000"

7. Lihat di halaman "Sewa Anda" → ada 3 transaksi baru ✅
```

---

## 🧪 Testing Scenarios

### Test 1: Single Item Purchase
```
✓ Tambah 1 alat, 3 hari penyewaan
✓ Buka keranjang, lihat 1 item
✓ Checkout, submit
✓ Verifikasi: 1 transaksi dibuat
✓ Verifikasi: Total harga = 3 × harga/hari
```

### Test 2: Multiple Different Items
```
✓ Tambah Tenda (3 hari × Rp 50k)
✓ Tambah Sleeping Bag (2 hari × Rp 30k)
✓ Tambah Backpack (5 hari × Rp 20k)
✓ Keranjang: 3 items, total Rp 310k
✓ Checkout: 3 transaksi dengan total benar
✓ Verifikasi: Hari dihitung benar per-item
```

### Test 3: Same Item Different Dates
```
✓ Tambah Tenda (5 Feb - 7 Feb = 3 hari)
✓ Tambah Tenda lagi (10 Feb - 12 Feb = 3 hari)
✓ Keranjang: 2 items TERPISAH (bukan merged)
✓ Checkout: 2 transaksi, masing-masing dengan date berbeda
```

### Test 4: Hapus Item
```
✓ Tambah 3 alat ke keranjang
✓ Buka keranjang
✓ Klik [🗑️ Hapus] pada item ke-2
✓ Item ke-2 hilang
✓ Keranjang sekarang: 2 items
✓ Total dihitung ulang otomatis
```

### Test 5: Kosongkan Keranjang
```
✓ Tambah 3 alat
✓ Buka keranjang
✓ Klik [🗑️ Kosongkan Keranjang]
✓ Confirm dialog muncul
✓ Semua item hilang
✓ Badge 🛒 di navbar hilang/clear
```

### Test 6: Validasi Tanggal
```
✓ Buka modal form
✓ Isi Tanggal Sewa: 10 Feb
✓ Isi Tanggal Kembali: 8 Feb (lebih awal dari sewa)
✓ Alert: "Tanggal kembali harus sama atau setelah tanggal sewa"
✓ Field Tanggal Kembali direset
```

### Test 7: Day Calculation Accuracy
```
Test Case 1:
✓ Sewa: 5 Feb, Kembali: 5 Feb
✓ Expected: 1 hari (same day = 1 day)
✓ Verify: Subtotal = 1 × harga ✅

Test Case 2:
✓ Sewa: 5 Feb, Kembali: 8 Feb
✓ Calculation: 8 - 5 + 1 = 4 hari
✓ Expected: 4 hari ✅

Test Case 3:
✓ Sewa: 28 Jan, Kembali: 5 Feb
✓ Calculation: 5 - 28 + 1 = -22... wait, cross-month!
✓ System use Carbon diffInDays: correct calculation
✓ Expected: 9 hari ✅
```

---

## 📱 Mobile Testing

```
✓ Open di HP/tablet
✓ Navbar terlihat dengan cart icon
✓ Alat cards responsive (1-2 kolom)
✓ Modal form terlihat dengan baik
✓ Keranjang page responsive
✓ Checkout form field stacked vertical
✓ Buttons clickable dengan ukuran cukup
✓ Tidak ada horizontal scroll
```

---

## 🔍 Debugging Tips

### Jika keranjang tidak nampak badge:
```
→ Check browser console (F12 → Console tab)
→ Pastikan session enabled di config/session.php
→ Try clear cookies → reload page
```

### Jika modal tidak terbuka:
```
→ Check console untuk JavaScript errors
→ Verifikasi Bootstrap 5 CSS/JS loaded
→ Try browser inspect element → check modal div
```

### Jika hitung hari salah:
```
→ Check browser console → hitung manual
→ Verifikasi tanggal format: YYYY-MM-DD
→ Cek backend logs: storage/logs/laravel.log
```

### Jika checkout form tidak submit:
```
→ Check form validation errors (alert muncul?)
→ Verify semua field terisi
→ Check network tab → POST request ke /transaksi_sewa
→ Cek status code: 200 OK atau error?
```

---

## ✅ Success Indicators

Sistem berfungsi dengan baik jika:

- [x] Tombol "🛒 Sewa Sekarang" ada di setiap alat card
- [x] Modal terbuka saat tombol diklik
- [x] Jumlah hari auto-calculated saat pilih tanggal
- [x] Subtotal auto-calculated
- [x] Item berhasil ditambah ke keranjang (reload page)
- [x] Cart badge muncul di navbar dengan angka benar
- [x] Halaman keranjang tampil dengan semua item
- [x] Total pembayaran dihitung benar
- [x] Tombol hapus per-item berfungsi
- [x] Checkout page responsive & form lengkap
- [x] Submit checkout berhasil (redirect + success message)
- [x] Transaksi muncul di halaman "Sewa Anda"
- [x] Multiple items = multiple transaksi (bukan 1 transaksi)
- [x] Hari dihitung benar di setiap transaksi

---

## 🎓 Learning Resources

Jika ingin modify/extend sistem:

1. **CartController Logic**: `app/Http/Controllers/CartController.php`
   - Lihat method `add()` untuk pahami cara hitung hari

2. **TransaksiSewaController**: `app/Http/Controllers/TransaksiSewaController.php`
   - Lihat method `storeFromCheckout()` untuk checkout flow

3. **Views**: `resources/views/cart/`
   - `index.blade.php` - Tampilan keranjang
   - `checkout.blade.php` - Form checkout

4. **Routes**: `routes/web.php`
   - Search "CART" untuk lihat semua cart routes

---

**Happy Testing! 🎉**

Untuk pertanyaan atau bug report, dokumentasi lengkap ada di:
- `SHOPPING_CART_DOCS.md` - Dokumentasi teknis
- `CART_IMPLEMENTATION_SUMMARY.md` - Ringkasan implementasi
