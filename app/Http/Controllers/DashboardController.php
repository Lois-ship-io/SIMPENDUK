<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use App\Models\Penduduk;
use App\Models\Wilayah;
use App\Models\Kematian;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $stats = [];
        $chartData = [];

        $pendudukQuery = Penduduk::query();
        $kematianQuery = Kematian::query();

        if ($user->role === 'RT') {
            $pendudukQuery->where('wilayah_id', $user->wilayah_id);
            $kematianQuery->whereHas('penduduk', function($q) use ($user) {
                $q->where('wilayah_id', $user->wilayah_id);
            });
        } else {
            $stats['total_wilayah'] = Wilayah::count();
            if ($user->role === 'SuperAdmin') {
                $stats['total_pengguna'] = User::count();
            }
        }

        $stats['total_penduduk'] = $pendudukQuery->count();
        $stats['total_kematian'] = $kematianQuery->count();

        // Chart Data Extraction
        $chartData['gender'] = (clone $pendudukQuery)
            ->select('jenis_kelamin', DB::raw('count(*) as total'))
            ->groupBy('jenis_kelamin')
            ->pluck('total', 'jenis_kelamin')->toArray();

        $chartData['agama'] = (clone $pendudukQuery)
            ->select('agama', DB::raw('count(*) as total'))
            ->groupBy('agama')
            ->pluck('total', 'agama')->toArray();
            
        $chartData['status'] = (clone $pendudukQuery)
            ->select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status')->toArray();

        return view('dashboard', compact('stats', 'chartData'));
    }
}
