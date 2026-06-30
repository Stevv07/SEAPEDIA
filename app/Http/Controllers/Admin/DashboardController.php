<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\SalesReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        // Ambil total user dengan role 'pembeli'
        $totalUsers = User::where('role', 'pembeli')->count();

        // Ambil total order dari tabel sales_reports
        $totalOrders = SalesReport::count();

        // Hitung total sales secara manual dari piece x price_per_piece
        $totalSales = SalesReport::all()->sum(function ($report) {
            return $report->piece * $report->price_per_piece;
        });

        // Ambil data penjualan per bulan dari tabel sales_reports
        $salesDataRaw = SalesReport::select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('SUM(piece * price_per_piece) as total')
            )
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->orderBy(DB::raw('MONTH(created_at)'))
            ->get();

        // Buat array default 12 bulan dengan nilai 0
        $months = [
            'Jan' => 0, 'Feb' => 0, 'Mar' => 0, 'Apr' => 0,
            'May' => 0, 'Jun' => 0, 'Jul' => 0, 'Aug' => 0,
            'Sep' => 0, 'Oct' => 0, 'Nov' => 0, 'Dec' => 0,
        ];

        // Mapping hasil query ke nama bulan
        foreach ($salesDataRaw as $item) {
            $monthName = date('M', mktime(0, 0, 0, $item->month, 1));
            $months[$monthName] = $item->total;
        }

        return view('pages.admin.dashboard', [
            'salesData' => $months,
            'totalUsers' => $totalUsers,
            'totalOrders' => $totalOrders,
            'totalSales' => $totalSales,
            'active_menu' => 'dashboard'
        ]);
    }
}
