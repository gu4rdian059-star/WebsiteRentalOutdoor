<?php

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/bootstrap/app.php';

// Get all settings
$settings = \App\Models\Setting::all();

echo "========== DATABASE SETTINGS ==========\n\n";
foreach ($settings as $setting) {
    echo "Key: {$setting->key}\n";
    echo "Value: {$setting->value}\n";
    echo "---\n";
}

echo "\n========== TEST GET HELPER ==========\n\n";
echo "Alamat: " . \App\Models\Setting::get('alamat', 'DEFAULT') . "\n";
echo "Latitude: " . \App\Models\Setting::get('latitude', 'DEFAULT') . "\n";
echo "Longitude: " . \App\Models\Setting::get('longitude', 'DEFAULT') . "\n";
echo "Telepon: " . \App\Models\Setting::get('telepon', 'DEFAULT') . "\n";

echo "\n✅ Settings verification complete!\n";
