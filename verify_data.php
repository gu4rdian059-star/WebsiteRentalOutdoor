<?php
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

try {
    // Check admin user
    $admin = \App\Models\User::where('email', 'admin@gmail.com')->first();
    if ($admin) {
        echo "✅ Admin user found:\n";
        echo "   - Email: " . $admin->email . "\n";
        echo "   - Name: " . $admin->name . "\n";
        echo "   - Role: " . $admin->role . "\n";
    } else {
        echo "❌ Admin user NOT found\n";
    }
    
    echo "\n";
    
    // Check alat count
    $alatCount = \App\Models\Alat::count();
    echo "✅ Total Alat: " . $alatCount . "\n\n";
    
    // List all alat
    $alats = \App\Models\Alat::all();
    echo "Daftar Alat:\n";
    foreach ($alats as $i => $alat) {
        echo ($i + 1) . ". " . $alat->nama_alat . " (Stok: " . $alat->stok . ", Harga: Rp " . number_format($alat->harga_sewa, 0, ',', '.') . ")\n";
    }
    
} catch (\Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
