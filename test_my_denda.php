<?php

require_once 'vendor/autoload.php';

use App\Models\User;
use App\Models\Denda;
use Illuminate\Foundation\Application;
use Illuminate\Contracts\Console\Kernel;
use Illuminate\Support\Facades\Auth;

$app = require_once 'bootstrap/app.php';
$app->make(Kernel::class)->bootstrap();

echo "=== TESTING MY DENDA PAGE ===\n";

// Get the test penyewa user
$user = User::where('email', 'penyewa@example.com')->first();
if (!$user) {
    echo "ERROR: Test penyewa user not found\n";
    exit(1);
}
echo "Test user: {$user->name} (ID: {$user->id})\n";

// Simulate authentication
Auth::login($user);
echo "Logged in as: " . Auth::user()->name . "\n";

// Get dendas for this user
$userId = Auth::id();
$dendas = Denda::whereHas('transaksiSewa.pelanggan', function($query) use ($userId) {
    $query->where('user_id', $userId);
})
->with('transaksiSewa.pelanggan', 'transaksiSewa.alat', 'adminPelayu')
->orderBy('id_denda', 'desc')
->get();

echo "Found {$dendas->count()} denda records\n";

foreach ($dendas as $denda) {
    echo "Denda ID: {$denda->id_denda}\n";
    echo "Total denda: {$denda->total_denda}\n";
    echo "Potongan: {$denda->potongan_denda}\n";
    echo "Denda akhir: {$denda->denda_akhir}\n";
    echo "Has potong: " . ($denda->hasPotong() ? 'Yes' : 'No') . "\n";
    echo "Alasan potongan: " . ($denda->alasan_potongan ?: 'None') . "\n";
    echo "---\n";
}

echo "Test completed successfully - no BadMethodCallException!\n";
