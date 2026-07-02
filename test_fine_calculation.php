<?php

require_once 'vendor/autoload.php';

use App\Models\User;
use App\Models\Pelanggan;
use App\Models\Alat;
use App\Models\TransaksiSewa;
use App\Models\Denda;
use Illuminate\Foundation\Application;
use Illuminate\Contracts\Console\Kernel;

$app = require_once 'bootstrap/app.php';
$app->make(Kernel::class)->bootstrap();

echo "=== TESTING FINE CALCULATION ===\n";

// Get admin user
$user = User::where('role', 'admin')->first();
if (!$user) {
    echo "ERROR: No admin user found\n";
    exit(1);
}
echo "Admin user: {$user->name} (ID: {$user->id})\n";

// Get first alat
$alat = Alat::first();
if (!$alat) {
    echo "ERROR: No alat found\n";
    exit(1);
}
echo "Alat: {$alat->nama_alat} (ID: {$alat->id_alat}, Harga: {$alat->harga_sewa})\n";

// Create test pelanggan
$pelanggan = Pelanggan::create([
    'nama_pelanggan' => 'Test User',
    'email_pelanggan' => 'test@example.com',
    'no_telepon' => '123456789',
    'alamat_pelanggan' => 'Test Address'
]);
echo "Created pelanggan ID: {$pelanggan->id_pelanggan}\n";

// Create test transaction (rent 06/02/2024, return 08/02/2024 - past dates to simulate late return)
$transaksi = TransaksiSewa::create([
    'user_id' => $user->id,
    'id_pelanggan' => $pelanggan->id_pelanggan,
    'id_alat' => $alat->id_alat,
    'tanggal_sewa' => '2024-02-06',
    'tanggal_kembali' => '2024-02-08',
    'jumlah_hari' => 3,
    'jumlah_satuan' => 1,
    'total_harga' => $alat->harga_sewa * 3,
    'status' => 'disewa',
    'denda' => 0,
    'payment_status' => 'confirmed'
]);
echo "Created transaction ID: {$transaksi->id_sewa}\n";
echo "Initial status: {$transaksi->status}, denda: {$transaksi->denda}\n";

// Simulate admin changing status to 'terlambat'
echo "\n=== CHANGING STATUS TO 'TERLAMBAT' ===\n";
$transaksi->status = 'terlambat';
$hariTerlambat = now()->diffInDays(\Carbon\Carbon::parse($transaksi->tanggal_kembali));
$calculatedDenda = $hariTerlambat > 0 ? $hariTerlambat * 5000 : 0;
$transaksi->denda = $calculatedDenda;
$transaksi->save();

echo "Days late: {$hariTerlambat}\n";
echo "Calculated fine: {$calculatedDenda}\n";
echo "Stored denda: {$transaksi->denda}\n";

// Check if Denda record was created
$dendaRecord = Denda::where('id_sewa', $transaksi->id_sewa)->first();
if ($dendaRecord) {
    echo "Denda record created: ID {$dendaRecord->id_denda}, Total: {$dendaRecord->total_denda}\n";
} else {
    echo "ERROR: Denda record not created\n";
}

// Test getDendaAttribute
echo "getDendaAttribute() returns: {$transaksi->denda}\n";

// Simulate changing to 'selesai'
echo "\n=== CHANGING STATUS TO 'SELESAI' ===\n";
$transaksi->status = 'selesai';
$transaksi->denda = 0;
$transaksi->save();

echo "Status: {$transaksi->status}, denda: {$transaksi->denda}\n";

// Check if Denda record was removed
$dendaRecordAfter = Denda::where('id_sewa', $transaksi->id_sewa)->first();
if (!$dendaRecordAfter) {
    echo "Denda record removed successfully\n";
} else {
    echo "ERROR: Denda record still exists\n";
}

// Test dashboard sum
echo "\n=== TESTING DASHBOARD SUM ===\n";
$totalDenda = TransaksiSewa::where('payment_status', 'confirmed')->sum('denda');
echo "Total stored denda: {$totalDenda}\n";

echo "\n=== TEST COMPLETED ===\n";
