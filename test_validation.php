<?php
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

try {
    // Get first alat
    $alat = \App\Models\Alat::first();
    
    if (!$alat) {
        echo "❌ No alat found in database\n";
        exit(1);
    }
    
    echo "✅ Test: Check alat can be queried\n";
    echo "   Alat found: " . $alat->nama_alat . " (ID: " . $alat->id_alat . ")\n";
    
    // Test findOrFail
    $testAlat = \App\Models\Alat::findOrFail($alat->id_alat);
    echo "✅ findOrFail works: " . $testAlat->nama_alat . "\n";
    
    // Check table name
    echo "✅ Model table: " . (new \App\Models\Alat())->getTable() . "\n";
    echo "✅ Model primary key: " . (new \App\Models\Alat())->getKeyName() . "\n";
    
} catch (\Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "Stack: " . $e->getTraceAsString() . "\n";
}

