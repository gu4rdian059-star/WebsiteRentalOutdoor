<?php
// Generate placeholder images
$images = [
    'tenda.jpg' => 'Tenda Camping',
    'sleepingbag.jpg' => 'Sleeping Bag',
    'kompor.jpg' => 'Kompor Portable',
    'matras.jpg' => 'Matras Camping',
    'headlamp.jpg' => 'Headlamp',
    'sepatu.png' => 'Sepatu Hiking',
    'osprey.jpg' => 'Osprey Backpack',
    'treking.jpg' => 'Trekking Pole',
    'nesting.png' => 'Nesting Pot',
    'arjuno.jpg' => 'Gunung Arjuno',
    'penanggungan.jpg' => 'Gunung Penanggungan',
    'raung.png' => 'Gunung Raung',
    'haha.jpg' => 'Haha Hihi',
    'hayya.jpg' => 'Hayya Hayyi'
];

$dir = __DIR__ . '/public/images/alat/';

// Create directory if it doesn't exist
if (!is_dir($dir)) {
    mkdir($dir, 0755, true);
}

foreach ($images as $filename => $label) {
    $filepath = $dir . $filename;
    
    // Skip if file exists
    if (file_exists($filepath)) {
        echo "[SKIP] $filename already exists\n";
        continue;
    }
    
    // Create image using GD
    $width = 400;
    $height = 300;
    $image = imagecreatetruecolor($width, $height);
    
    // Colors
    $bgColor = imagecolorallocate($image, 52, 152, 219);      // Blue
    $textColor = imagecolorallocate($image, 255, 255, 255);   // White
    $borderColor = imagecolorallocate($image, 41, 128, 185);  // Dark Blue
    
    // Fill background
    imagefill($image, 0, 0, $bgColor);
    
    // Draw border
    imagerectangle($image, 0, 0, $width - 1, $height - 1, $borderColor);
    imageline($image, 0, 0, $width - 1, $height - 1, $borderColor);
    imageline($image, $width - 1, 0, 0, $height - 1, $borderColor);
    
    // Add text
    $font = 5; // Built-in font
    $textWidth = strlen($label) * imagefontwidth($font);
    $x = ($width - $textWidth) / 2;
    $y = ($height - imagefontheight($font)) / 2;
    imagestring($image, $font, $x, $y, $label, $textColor);
    
    // Save image
    $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
    if ($ext === 'jpg' || $ext === 'jpeg') {
        imagejpeg($image, $filepath, 85);
    } else {
        imagepng($image, $filepath);
    }
    
    imagedestroy($image);
    echo "[OK] $filename created successfully\n";
}

echo "\nAll placeholder images generated!\n";
