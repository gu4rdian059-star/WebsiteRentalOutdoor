<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Alat;
use App\Models\TransaksiSewa;
use App\Models\Pelanggan;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        /* =============================
         | LIST ALAT
         ============================= */
        $query = Alat::query();

        if ($request->filled('q')) {
            $query->where('nama_alat', 'like', '%' . $request->q . '%')
                  ->orWhere('kategori', 'like', '%' . $request->q . '%');
            $alats = $query->get();
        } else {
            $alats = $query->take(4)->get();
        }

        /* =============================
         | TRANSAKSI USER LOGIN
         ============================= */
        $userTransaksi = collect();

        if (auth()->check()) {
            $userTransaksi = TransaksiSewa::where('user_id', auth()->id())
                ->with(['alat', 'pelanggan'])
                ->orderByDesc('id_sewa')
                ->get();
        }

        /* =============================
         | TRANSAKSI BULAN INI (ADMIN)
         ============================= */
        $bulanIni = Carbon::now();

        $totalTransaksi = TransaksiSewa::whereYear('created_at', $bulanIni->year)
            ->whereMonth('created_at', $bulanIni->month)
            ->count();

        $totalPendapatan = TransaksiSewa::whereYear('created_at', $bulanIni->year)
            ->whereMonth('created_at', $bulanIni->month)
            ->where('payment_status', 'confirmed')
            ->sum('total_harga');



        /* =============================
         | ALAMAT
         ============================= */
        $alamat = 'Jl. Raya Magersari Pleret, Kec. Pohjentrek, Kab. Pasuruan, Jawa Timur, Indonesia';

        return view('home', compact(
            'alats',
            'userTransaksi',
            'alamat',
            'totalPendapatan'
        ));
    }

    public function profile()
    {
        $user = auth()->user();
        $pelanggan = Pelanggan::where('email_pelanggan', $user->email)->first();

        return view('profile', compact('user', 'pelanggan'));
    }
}
