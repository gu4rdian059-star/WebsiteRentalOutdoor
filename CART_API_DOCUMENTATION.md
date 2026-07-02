# 🔌 Cart API Documentation

## Overview

Shopping cart system menggunakan **Session-based storage** dengan Laravel. Semua cart operations dapat diakses melalui HTTP endpoints atau langsung via `session()` helper.

---

## 📍 Endpoints

### 1. View Cart
```
GET /cart
Route Name: cart.index
Controller: CartController@index
Return: View dengan data cart & total

Response Body:
{
  "cart": [
    "{id_alat}_{tgl_sewa}_{tgl_kembali}": {
      "id_alat": 1,
      "nama_alat": "Tenda 2 Orang",
      "kategori": "Camping",
      "gambar": "tenda.jpg",
      "harga_sewa": 50000,
      "tgl_sewa": "2026-02-05",
      "tgl_kembali": "2026-02-08",
      "jumlah_hari": 4,
      "subtotal": 200000
    }
  ],
  "total": 200000
}
```

### 2. Add to Cart
```
POST /cart/add
Route Name: cart.add
Controller: CartController@add
Content-Type: application/json

Request Body:
{
  "id_alat": 1,
  "tgl_sewa": "2026-02-05",
  "tgl_kembali": "2026-02-08"
}

Response (JSON):
{
  "success": true,
  "message": "Tenda 2 Orang ditambahkan ke keranjang!",
  "cart_count": 1
}

Errors:
- 422: Validation failed (alat tidak ada, tanggal format salah)
```

### 3. Remove Item from Cart
```
DELETE /cart/{cartKey}
Route Name: cart.remove
Controller: CartController@remove
Parameter: cartKey (format: {id_alat}_{tgl_sewa}_{tgl_kembali})

Example URL:
DELETE /cart/1_2026-02-05_2026-02-08

Response:
Redirect to /cart with success message
```

### 4. Clear Cart
```
POST /cart/clear
Route Name: cart.clear
Controller: CartController@clear

Response:
Redirect to /cart with success message
```

### 5. Checkout Page
```
GET /cart/checkout
Route Name: cart.checkout
Controller: CartController@checkout
Return: View checkout form dengan cart data

Response Body (View):
{
  "cart": [...],
  "total": 200000
}
```

---

## 💾 Session Structure

### Session Key: `cart`

```php
// Empty Cart
session('cart') // [] atau tidak ada

// With Items
session('cart') === [
  "1_2026-02-05_2026-02-08" => [
    "id_alat" => 1,
    "nama_alat" => "Tenda 2 Orang",
    "kategori" => "Camping",
    "gambar" => "tenda.jpg",
    "harga_sewa" => 50000,
    "tgl_sewa" => "2026-02-05",
    "tgl_kembali" => "2026-02-08",
    "jumlah_hari" => 4,
    "subtotal" => 200000
  ],
  "2_2026-02-10_2026-02-12" => [
    "id_alat" => 2,
    "nama_alat" => "Sleeping Bag",
    "kategori" => "Camping",
    "gambar" => "sbag.jpg",
    "harga_sewa" => 30000,
    "tgl_sewa" => "2026-02-10",
    "tgl_kembali" => "2026-02-12",
    "jumlah_hari" => 3,
    "subtotal" => 90000
  ]
]
```

### Accessing Cart in Controller/Blade:

```php
// Get cart data
$cart = session('cart', []);

// Get total
$total = array_sum(array_column($cart, 'subtotal'));

// Count items
$count = count($cart);

// Check if empty
if (empty($cart)) {
  // Cart is empty
}
```

---

## 📊 Data Flow

### Add Item Flow:
```
User clicks "Sewa Sekarang" 
         ↓
Modal opens with form
         ↓
User selects dates & submits
         ↓
JavaScript: POST /cart/add (JSON)
         ↓
CartController::add() validates
         ↓
Calculate: jumlah_hari = diffInDays + 1
         ↓
Calculate: subtotal = jumlah_hari × harga_sewa
         ↓
Create unique key: {id_alat}_{tgl_sewa}_{tgl_kembali}
         ↓
Store in session: session()->put('cart', $cart)
         ↓
Return JSON response
         ↓
JavaScript: alert success & location.reload()
         ↓
Page reloads → navbar badge updates
```

### Checkout Flow:
```
User in cart page clicks "Checkout"
         ↓
GET /cart/checkout
         ↓
CartController::checkout() loads cart from session
         ↓
Return checkout.blade.php with:
  - $cart (array of items)
  - $total (sum of subtotals)
         ↓
User fills form & clicks "Lanjut"
         ↓
POST /transaksi_sewa with:
  - cart_data (JSON encoded)
  - nama_penyewa, email, etc.
  - from_checkout=1
         ↓
TransaksiSewaController::store() detects from_checkout
         ↓
Calls storeFromCheckout() method
         ↓
Creates 1 Pelanggan record
         ↓
Loop each cart item:
  - Recalculate jumlah_hari
  - Create TransaksiSewa record
         ↓
Clear session: session()->forget('cart')
         ↓
Redirect to transaksi_sewa.index with success message
```

---

## 🔐 Validation Rules

### Add to Cart:
```php
'id_alat' => 'required|exists:alats,id_alat',
'tgl_sewa' => 'required|date',
'tgl_kembali' => 'required|date|after_or_equal:tgl_sewa',
```

### Checkout Form:
```php
'cart_data' => 'required|json',
'nama_penyewa' => 'required|string',
'email_penyewa' => 'required|email',
'no_telepon' => 'required|string',
'alamat_penyewa' => 'required|string',
'metode_pembayaran' => 'required|in:transfer_bank,e_wallet',
'total_amount' => 'required|numeric|min:1',
```

---

## 📐 Calculation Methods

### Day Calculation (JavaScript - Frontend):
```javascript
const tglSewa = new Date(dateString1); // YYYY-MM-DD
const tglKembali = new Date(dateString2); // YYYY-MM-DD

const selisih = tglKembali.getTime() - tglSewa.getTime();
const jumlahHari = Math.ceil(selisih / (1000 * 60 * 60 * 24)) + 1;
```

### Day Calculation (PHP - Backend Cart):
```php
$tglSewa = new \DateTime($validated['tgl_sewa']);
$tglKembali = new \DateTime($validated['tgl_kembali']);
$selisih = $tglKembali->getTimestamp() - $tglSewa->getTimestamp();
$jumlahHari = ceil($selisih / 86400) + 1; // 86400 = 24*60*60

if ($jumlahHari <= 0) {
  $jumlahHari = 1;
}
```

### Day Calculation (PHP - Backend Transaksi):
```php
$tglSewa = Carbon::parse($item['tgl_sewa']);
$tglKembali = Carbon::parse($item['tgl_kembali']);

$calculatedDays = $tglKembali->diffInDays($tglSewa) + 1;
if ($calculatedDays <= 0) {
  $calculatedDays = 1;
}

$itemTotal = $calculatedDays * $alat->harga_sewa;
```

### Price Calculation:
```
subtotal = jumlah_hari × harga_sewa
total = SUM(subtotal untuk semua items)
```

---

## 🛑 Error Handling

### Frontend Errors (JavaScript):

```javascript
// Network error
if (response.error) {
  alert('Terjadi kesalahan: ' + error.message);
}

// Validation errors
if (!data.success) {
  alert('Error: ' + data.message);
}
```

### Backend Errors (PHP):

```php
// 422 Unprocessable Entity (Validation fails)
return response()->json([
  'errors' => $validator->errors(),
], 422);

// 404 Not Found (Alat tidak ada)
throw new ModelNotFoundException();

// 302 Redirect (Cart empty saat checkout)
return redirect()->route('cart.index')
  ->with('error', 'Keranjang kosong!');
```

---

## 🧮 Example Calculations

### Scenario 1: Single Item
```
POST /cart/add
{
  "id_alat": 1,
  "tgl_sewa": "2026-02-05",
  "tgl_kembali": "2026-02-08"
}

Backend calculates:
- jumlah_hari = (8 Feb - 5 Feb) + 1 = 4 hari
- Assume harga_sewa = 50,000
- subtotal = 4 × 50,000 = 200,000

Session now contains:
$cart["1_2026-02-05_2026-02-08"] = [
  "jumlah_hari" => 4,
  "subtotal" => 200000
]
```

### Scenario 2: Multiple Items
```
Add item 1: Tenda (3 hari × Rp 50k) = Rp 150,000
Add item 2: Sleeping Bag (2 hari × Rp 30k) = Rp 60,000
Add item 3: Backpack (5 hari × Rp 20k) = Rp 100,000

Session:
$cart = [
  "1_2026-02-05_2026-02-08" => [..., "subtotal" => 150000],
  "2_2026-02-10_2026-02-12" => [..., "subtotal" => 60000],
  "3_2026-02-15_2026-02-20" => [..., "subtotal" => 100000],
]

Total = 150,000 + 60,000 + 100,000 = 310,000
```

### Scenario 3: Checkout
```
POST /transaksi_sewa
{
  "cart_data": "[above JSON]",
  "nama_penyewa": "Budi Santoso",
  "email_penyewa": "budi@gmail.com",
  "no_telepon": "08123456789",
  "alamat_penyewa": "Jl. Merdeka 123",
  "metode_pembayaran": "transfer_bank",
  "total_amount": 310000,
  "from_checkout": 1
}

Backend:
1. Validate all fields ✓
2. Create Pelanggan record
3. For each item in cart_data:
   - Recalculate hari (extra safety)
   - Create TransaksiSewa record
   - Store in DB
4. Clear cart: session()->forget('cart')
5. Return redirect with message
```

---

## 🔄 Important Notes

1. **Session Duration**: Cart data persists until:
   - User logout (session destroyed)
   - Session timeout (usually 120 minutes)
   - User explicitly clear cookies
   - Server restart

2. **No Database Storage**: Cart items NOT stored in database
   - Faster performance
   - No need migration
   - Lost if session cleared

3. **Unique Key Strategy**: `{id_alat}_{tgl_sewa}_{tgl_kembali}`
   - Allows same alat with different dates
   - Example: Tenda 5-7 Feb ≠ Tenda 10-12 Feb → 2 separate items

4. **Backend Recalculation**: Always recalculate days in backend
   - Never trust frontend calculations
   - Use Carbon for date math (handles months/years correctly)

5. **One Pelanggan per Checkout**: All items in one checkout → 1 Pelanggan
   - Multiple TransaksiSewa records (one per alat)
   - Easier tracking & management

---

## 🔧 Extending the System

### Add Discount/Coupon:
```php
// In checkout form validation
'coupon_code' => 'nullable|string',

// In storeFromCheckout()
if ($request->coupon_code) {
  $discount = calculateDiscount($request->coupon_code, $total);
  $total -= $discount;
}
```

### Add Quantity:
```php
// Change cart structure
$cart["{id_alat}_{tgl_sewa}_{tgl_kembali}"] = [
  "quantity" => 2, // Add this
  "subtotal" => 2 * (hari * harga)
];
```

### Add Payment Gateway:
```php
// In storeFromCheckout(), after transaction created
if ($request->metode_pembayaran === 'online') {
  return redirect()->to(generatePaymentLink($transaksi));
}
```

---

## 📝 Code Examples

### Access cart in blade:
```blade
@php
  $cart = session('cart', []);
  $total = array_sum(array_column($cart, 'subtotal'));
@endphp

<p>{{ count($cart) }} items in cart</p>
<p>Total: Rp {{ number_format($total, 0, ',', '.') }}</p>
```

### Access cart in controller:
```php
public function index() {
  $cart = session()->get('cart', []);
  $total = 0;
  
  foreach ($cart as $item) {
    $total += $item['subtotal'];
  }
  
  return view('cart.index', compact('cart', 'total'));
}
```

### Modify cart in controller:
```php
// Add item
$cart = session()->get('cart', []);
$cart[$key] = $itemData;
session()->put('cart', $cart);

// Remove item
$cart = session()->get('cart', []);
unset($cart[$key]);
session()->put('cart', $cart);

// Clear all
session()->forget('cart');
```

---

**Documentation Version**: 1.0
**Last Updated**: 5 Februari 2026
**Status**: Complete ✅
