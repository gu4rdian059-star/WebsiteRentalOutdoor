<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TransaksiSewa;
use App\Models\Alat;
use App\Models\Pelanggan;
use App\Models\Denda;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // =============================
        // TANGGAL BULAN INI
        // =============================
        $awalBulan = Carbon::now()->startOfMonth();
        $akhirBulan = Carbon::now()->endOfMonth();

        // =============================
        // JUMLAH TRANSAKSI BULAN INI
        // =============================
        $transaksiBulanIni = TransaksiSewa::whereBetween('created_at', [
                $awalBulan,
                $akhirBulan
            ])->count();

        // =============================
        // PENDAPATAN BULAN INI (CONFIRMED)
        // =============================
        $pendapatanBulanIni = TransaksiSewa::where('payment_status', 'confirmed')
            ->whereBetween('created_at', [$awalBulan, $akhirBulan])
            ->sum(DB::raw('COALESCE(total_harga,0) + COALESCE(denda,0)'));

        // =============================
        // TOTAL SEMUA TRANSAKSI
        // =============================
        $totalTransaksi = TransaksiSewa::count();

        // =============================
        // TOTAL SEMUA PENDAPATAN
        // =============================
        $totalPendapatan = TransaksiSewa::where('payment_status', 'confirmed')
            ->sum(DB::raw('COALESCE(total_harga,0) + COALESCE(denda,0)'));

        // =============================
        // STOK KOSONG WARNING
        // =============================
        $stokKosong = Alat::where('stok', '<=', 0)->count();
        $alatStokKosong = Alat::where('stok', '<=', 0)->get();

        // =============================
        // ADDITIONAL DATA FOR DASHBOARD
        // =============================
        $totalAlat = Alat::count();
        $totalPelanggan = Pelanggan::count();
        $sedangDisewa = TransaksiSewa::where('status', 'disewa')->count();
        $totalDenda = Denda::whereRaw('total_denda - COALESCE(potongan_denda, 0) > 0')->count();

        // Recent transactions (last 8)
        $recentTransaksi = TransaksiSewa::with(['pelanggan', 'alat'])
            ->orderBy('created_at', 'desc')
            ->limit(8)
            ->get();

        return view('admin.dashboard', compact(
            'transaksiBulanIni',
            'pendapatanBulanIni',
            'totalTransaksi',
            'totalPendapatan',
            'stokKosong',
            'alatStokKosong',
            'totalAlat',
            'totalPelanggan',
            'sedangDisewa',
            'totalDenda',
            'recentTransaksi'
        ));
    }
}
