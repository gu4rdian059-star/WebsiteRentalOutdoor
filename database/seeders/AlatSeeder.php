<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Alat;

class AlatSeeder extends Seeder
{
    public function run(): void
    {
        $alats = [
            [
                'nama_alat' => 'Tenda Camping',
                'kategori' => 'Camping',
                'merk' => 'Coleman',
                'stok' => 10,
                'harga_sewa' => 50000,
                'gambar' => 'tenda.jpg',
                'deskripsi' => 'Tenda camping berkualitas tinggi dengan desain modern',
                'kegunaan' => 'Untuk mendirikan tempat tidur di alam terbuka'
            ],
            [
                'nama_alat' => 'Sleeping Bag',
                'kategori' => 'Camping',
                'merk' => 'Decathlon',
                'stok' => 15,
                'harga_sewa' => 25000,
                'gambar' => 'sleepingbag.jpg',
                'deskripsi' => 'Sleeping bag nyaman untuk outdoor',
                'kegunaan' => 'Untuk tidur hangat di luar ruangan'
            ],
            [
                'nama_alat' => 'Kompor Portable',
                'kategori' => 'Cooking',
                'merk' => 'PowerBox',
                'stok' => 8,
                'harga_sewa' => 30000,
                'gambar' => 'kompor.jpg',
                'deskripsi' => 'Kompor gas portable untuk memasak',
                'kegunaan' => 'Untuk memasak makanan saat camping'
            ],
            [
                'nama_alat' => 'Matras Camping',
                'kategori' => 'Camping',
                'merk' => 'Thermarest',
                'stok' => 12,
                'harga_sewa' => 20000,
                'gambar' => 'matras.jpg',
                'deskripsi' => 'Matras tidur dengan busa tebal',
                'kegunaan' => 'Untuk alas tidur yang empuk'
            ],
            [
                'nama_alat' => 'Headlamp',
                'kategori' => 'Lighting',
                'merk' => 'Petzl',
                'stok' => 20,
                'harga_sewa' => 15000,
                'gambar' => 'headlamp.jpg',
                'deskripsi' => 'Lampu kepala LED dengan baterai tahan lama',
                'kegunaan' => 'Untuk penerangan saat malam hari'
            ],
            [
                'nama_alat' => 'Sepatu Hiking',
                'kategori' => 'Footwear',
                'merk' => 'Salomon',
                'stok' => 6,
                'harga_sewa' => 40000,
                'gambar' => 'sepatu.png',
                'deskripsi' => 'Sepatu hiking profesional dengan grip sangat baik',
                'kegunaan' => 'Untuk mendaki gunung dengan aman'
            ],
            [
                'nama_alat' => 'Osprey Backpack',
                'kategori' => 'Backpack',
                'merk' => 'Osprey',
                'stok' => 5,
                'harga_sewa' => 60000,
                'gambar' => 'osprey.jpg',
                'deskripsi' => 'Ransel berkualitas tinggi dengan kapasitas besar',
                'kegunaan' => 'Untuk membawa perlengkapan saat traveling'
            ],
            [
                'nama_alat' => 'Trekking Pole',
                'kategori' => 'Hiking',
                'merk' => 'BlackDiamond',
                'stok' => 10,
                'harga_sewa' => 20000,
                'gambar' => 'treking.jpg',
                'deskripsi' => 'Tongkat trekking aluminum yang ringan',
                'kegunaan' => 'Untuk membantu keseimbangan saat mendaki'
            ],
            [
                'nama_alat' => 'Nesting Pot',
                'kategori' => 'Cooking',
                'merk' => 'Snow Peak',
                'stok' => 7,
                'harga_sewa' => 35000,
                'gambar' => 'nesting.png',
                'deskripsi' => 'Set panci nesting untuk memasak outdoor',
                'kegunaan' => 'Untuk memasak dan menyimpan makanan'
            ],
            [
                'nama_alat' => 'Gunung Arjuno',
                'kategori' => 'Destination',
                'merk' => 'Pasuruan',
                'stok' => 1,
                'harga_sewa' => 0,
                'gambar' => 'arjuno.jpg',
                'deskripsi' => 'Destinasi gunung yang indah di Pasuruan',
                'kegunaan' => 'Untuk mendaki dan menikmati pemandangan'
            ],
            [
                'nama_alat' => 'Gunung Penanggungan',
                'kategori' => 'Destination',
                'merk' => 'Tuban',
                'stok' => 1,
                'harga_sewa' => 0,
                'gambar' => 'penanggungan.jpg',
                'deskripsi' => 'Destinasi gunung batu yang menantang',
                'kegunaan' => 'Untuk pendakian adventure'
            ],
            [
                'nama_alat' => 'Gunung Raung',
                'kategori' => 'Destination',
                'merk' => 'Banyuwangi',
                'stok' => 1,
                'harga_sewa' => 0,
                'gambar' => 'raung.png',
                'deskripsi' => 'Gunung tertinggi di Jawa Timur',
                'kegunaan' => 'Untuk pendakian ekstrem'
            ],
            [
                'nama_alat' => 'Haha Hihi',
                'kategori' => 'Fun',
                'merk' => 'Random',
                'stok' => 1,
                'harga_sewa' => 0,
                'gambar' => 'haha.jpg',
                'deskripsi' => 'Item lucu untuk koleksi',
                'kegunaan' => 'Untuk bersenang-senang'
            ],
            [
                'nama_alat' => 'Hayya Hayyi',
                'kategori' => 'Fun',
                'merk' => 'Random',
                'stok' => 1,
                'harga_sewa' => 0,
                'gambar' => 'hayya.jpg',
                'deskripsi' => 'Item lucu untuk koleksi',
                'kegunaan' => 'Untuk bersenang-senang'
            ]
        ];

        foreach ($alats as $alat) {
            Alat::create($alat);
        }
    }
}
