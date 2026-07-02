<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    /**
     * Show settings form (admin only)
     */
    public function edit()
    {
        if (auth()->check() && auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized');
        }

        $alamat = Setting::get('alamat', 'Jl. Raya Magersari Pleret, Kec. Pohjentrek, Kab. Pasuruan, Jawa Timur, Indonesia');
        $latitude = Setting::get('latitude', '-7.519166');
        $longitude = Setting::get('longitude', '112.7275');
        $telepon = Setting::get('telepon', '+62 822-773-4933');

        return view('settings.edit', compact('alamat', 'latitude', 'longitude', 'telepon'));
    }

    /**
     * Update settings
     */
    public function update(Request $request)
    {
        if (auth()->check() && auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized');
        }

        $validated = $request->validate([
            'alamat' => 'required|string|max:500',
            'latitude' => 'required|regex:/^-?\d+(\.\d+)?$/',
            'longitude' => 'required|regex:/^-?\d+(\.\d+)?$/',
            'telepon' => 'required|string|max:20',
        ], [
            'latitude.regex' => 'Latitude harus berupa angka desimal (contoh: -7.519166)',
            'longitude.regex' => 'Longitude harus berupa angka desimal (contoh: 112.7275)',
        ]);

        Setting::set('alamat', $validated['alamat']);
        Setting::set('latitude', $validated['latitude']);
        Setting::set('longitude', $validated['longitude']);
        Setting::set('telepon', $validated['telepon']);

        return redirect()->back()->with('success', '✅ Pengaturan lokasi berhasil diperbarui! Google Maps akan otomatis berubah sesuai koordinat yang baru.');
    }
}
