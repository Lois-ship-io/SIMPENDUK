@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="mb-8">
    <div class="bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-700 rounded-3xl p-8 text-white shadow-xl relative overflow-hidden transition-all hover:shadow-2xl">
        <div class="relative z-10">
            <h2 class="text-3xl font-extrabold tracking-tight">Selamat datang, {{ auth()->user()->name }}! 🚀</h2>
            <p class="mt-2 text-blue-100 font-medium text-lg">Berikut adalah ringkasan informasi sistem SIMPENDUK saat ini.</p>
        </div>
        <div class="absolute top-0 right-0 -mr-20 -mt-20 opacity-20 transition-transform duration-700 hover:rotate-12">
            <svg class="w-64 h-64" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8z"/></svg>
        </div>
        <div class="absolute bottom-0 left-0 w-full h-1/2 bg-gradient-to-t from-black/10 to-transparent"></div>
    </div>
</div>

<!-- Stats Grid -->
<div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4 mb-8">
    <!-- Card Penduduk -->
    <div class="bg-white/90 backdrop-blur-md overflow-hidden shadow-sm rounded-2xl border border-blue-50 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 group">
        <div class="p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-gradient-to-br from-blue-400 to-blue-600 rounded-xl p-4 shadow-lg shadow-blue-200 group-hover:scale-110 group-hover:rotate-3 transition-transform duration-300">
                    <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-xs font-bold text-gray-500 uppercase tracking-wider">Total Penduduk</dt>
                        <dd>
                            <div class="text-3xl font-black text-gray-800 mt-1">{{ number_format($stats['total_penduduk'] ?? 0) }}</div>
                        </dd>
                    </dl>
                </div>
            </div>
        </div>
        <div class="bg-blue-50/50 px-6 py-3 border-t border-blue-100/50">
            <a href="{{ route('penduduk.index') }}" class="text-sm font-bold text-blue-600 hover:text-blue-900 flex items-center justify-between w-full transition-colors">
                <span>Lihat data penduduk</span>
                <svg class="ml-1.5 h-4 w-4 transform group-hover:translate-x-1 transition-transform flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </a>
        </div>
    </div>

    @if(isset($stats['total_wilayah']))
    <!-- Card Wilayah -->
    <div class="bg-white/90 backdrop-blur-md overflow-hidden shadow-sm rounded-2xl border border-emerald-50 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 group">
        <div class="p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-gradient-to-br from-emerald-400 to-emerald-600 rounded-xl p-4 shadow-lg shadow-emerald-200 group-hover:scale-110 group-hover:rotate-3 transition-transform duration-300">
                    <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-xs font-bold text-gray-500 uppercase tracking-wider">Total Wilayah (RT)</dt>
                        <dd>
                            <div class="text-3xl font-black text-gray-800 mt-1">{{ number_format($stats['total_wilayah']) }}</div>
                        </dd>
                    </dl>
                </div>
            </div>
        </div>
        <div class="bg-emerald-50/50 px-6 py-3 border-t border-emerald-100/50">
            <a href="{{ route('wilayah.index') }}" class="text-sm font-bold text-emerald-600 hover:text-emerald-900 flex items-center justify-between w-full transition-colors">
                <span>Kelola wilayah</span>
                <svg class="ml-1.5 h-4 w-4 transform group-hover:translate-x-1 transition-transform flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </a>
        </div>
    </div>
    @endif

    <!-- Card Kematian -->
    <div class="bg-white/90 backdrop-blur-md overflow-hidden shadow-sm rounded-2xl border border-rose-50 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 group">
        <div class="p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-gradient-to-br from-rose-400 to-rose-600 rounded-xl p-4 shadow-lg shadow-rose-200 group-hover:scale-110 group-hover:-rotate-3 transition-transform duration-300">
                    <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-xs font-bold text-gray-500 uppercase tracking-wider">Data Kematian</dt>
                        <dd>
                            <div class="text-3xl font-black text-gray-800 mt-1">{{ number_format($stats['total_kematian'] ?? 0) }}</div>
                        </dd>
                    </dl>
                </div>
            </div>
        </div>
        <div class="bg-rose-50/50 px-6 py-3 border-t border-rose-100/50">
            <a href="{{ route('kematian.index') }}" class="text-sm font-bold text-rose-600 hover:text-rose-900 flex items-center justify-between w-full transition-colors">
                <span>Lihat rekap kematian</span>
                <svg class="ml-1.5 h-4 w-4 transform group-hover:translate-x-1 transition-transform flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </a>
        </div>
    </div>

    @if(isset($stats['total_pengguna']))
    <!-- Card Pengguna -->
    <div class="bg-white/90 backdrop-blur-md overflow-hidden shadow-sm rounded-2xl border border-purple-50 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 group">
        <div class="p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-gradient-to-br from-purple-400 to-purple-600 rounded-xl p-4 shadow-lg shadow-purple-200 group-hover:scale-110 group-hover:rotate-3 transition-transform duration-300">
                    <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-xs font-bold text-gray-500 uppercase tracking-wider">Total Pengguna</dt>
                        <dd>
                            <div class="text-3xl font-black text-gray-800 mt-1">{{ number_format($stats['total_pengguna']) }}</div>
                        </dd>
                    </dl>
                </div>
            </div>
        </div>
        <div class="bg-purple-50/50 px-6 py-3 border-t border-purple-100/50">
            <a href="{{ route('pengguna.index') }}" class="text-sm font-bold text-purple-600 hover:text-purple-900 flex items-center justify-between w-full transition-colors">
                <span>Kelola pengguna</span>
                <svg class="ml-1.5 h-4 w-4 transform group-hover:translate-x-1 transition-transform flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </a>
        </div>
    </div>
    @endif
</div>

<!-- Charts Section -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
    <!-- Chart: Demografi Jenis Kelamin -->
    <div class="bg-white/90 backdrop-blur-xl rounded-2xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-shadow">
        <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
            <div class="bg-blue-100 p-2 rounded-lg mr-3">
                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
            </div>
            Demografi Kelamin
        </h3>
        <div class="relative h-64 w-full">
            <canvas id="genderChart"></canvas>
        </div>
    </div>

    <!-- Chart: Distribusi Agama -->
    <div class="bg-white/90 backdrop-blur-xl rounded-2xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-shadow">
        <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
            <div class="bg-purple-100 p-2 rounded-lg mr-3">
                <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
            </div>
            Distribusi Agama
        </h3>
        <div class="relative h-64 w-full">
            <canvas id="agamaChart"></canvas>
        </div>
    </div>

    <!-- Chart: Status Penduduk -->
    <div class="bg-white/90 backdrop-blur-xl rounded-2xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-shadow">
        <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
            <div class="bg-emerald-100 p-2 rounded-lg mr-3">
                <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            Status Penduduk
        </h3>
        <div class="relative h-64 w-full">
            <canvas id="statusChart"></canvas>
        </div>
    </div>
</div>

<!-- Extra Information based on Role -->
<div class="bg-gradient-to-r from-slate-800 to-slate-900 rounded-2xl p-6 shadow-xl relative overflow-hidden border border-slate-700">
    <div class="absolute top-0 right-0 p-4 opacity-10">
        <svg class="w-32 h-32 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
    </div>
    <div class="relative z-10 flex items-start">
        <div class="flex-shrink-0 bg-blue-500/20 p-3 rounded-xl border border-blue-500/30">
            <svg class="h-6 w-6 text-blue-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
            </svg>
        </div>
        <div class="ml-5 flex-1">
            <h4 class="text-base font-extrabold text-white flex items-center">
                Hak Akses Sistem
                <span class="bg-blue-600 text-white px-2.5 py-0.5 rounded-md text-xs ml-3 border border-blue-500 shadow-sm uppercase tracking-wide">{{ auth()->user()->role }}</span>
            </h4>
            <p class="mt-2 text-sm text-slate-300 leading-relaxed max-w-3xl">
                @if(auth()->user()->role === 'SuperAdmin')
                    Anda memiliki <strong class="text-white">akses tak terbatas</strong> untuk melihat, menambah, mengubah, dan menghapus seluruh data pada sistem SIMPENDUK. Jaga kerahasiaan data dengan baik.
                @elseif(auth()->user()->role === 'Admin')
                    Anda dapat mengelola data kependudukan, wilayah, serta operasional secara umum, kecuali manajemen akun tingkat SuperAdmin.
                @elseif(auth()->user()->role === 'RT')
                    Akses Anda dibatasi hanya untuk mengelola warga di wilayah <strong class="text-white bg-white/10 px-1.5 py-0.5 rounded">{{ auth()->user()->wilayah->nama ?? 'Anda' }}</strong>. Anda tidak dapat melihat atau mengubah data di luar cakupan RT Anda.
                @endif
            </p>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const chartData = @json($chartData ?? []);
        
        // Common Options
        const commonOptions = {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        usePointStyle: true,
                        padding: 20,
                        font: {
                            family: "'Inter', 'Segoe UI', sans-serif",
                            weight: '600'
                        },
                        color: '#475569'
                    }
                }
            }
        };

        // Gender Chart (Doughnut)
        if(chartData.gender && Object.keys(chartData.gender).length > 0) {
            const genderCtx = document.getElementById('genderChart').getContext('2d');
            new Chart(genderCtx, {
                type: 'doughnut',
                data: {
                    labels: Object.keys(chartData.gender).map(k => k === 'L' ? 'Laki-laki' : (k === 'P' ? 'Perempuan' : k)),
                    datasets: [{
                        data: Object.values(chartData.gender),
                        backgroundColor: ['#3b82f6', '#ec4899', '#9ca3af'], // blue, pink, gray fallback
                        borderWidth: 0,
                        hoverOffset: 4
                    }]
                },
                options: {
                    ...commonOptions,
                    cutout: '70%',
                    plugins: {
                        ...commonOptions.plugins,
                        tooltip: {
                            backgroundColor: 'rgba(15, 23, 42, 0.9)',
                            titleFont: { family: "'Inter', sans-serif" },
                            bodyFont: { family: "'Inter', sans-serif" },
                            padding: 12,
                            cornerRadius: 8
                        }
                    }
                }
            });
        }

        // Agama Chart (Bar)
        if(chartData.agama && Object.keys(chartData.agama).length > 0) {
            const agamaCtx = document.getElementById('agamaChart').getContext('2d');
            new Chart(agamaCtx, {
                type: 'bar',
                data: {
                    labels: Object.keys(chartData.agama),
                    datasets: [{
                        label: 'Jumlah Penduduk',
                        data: Object.values(chartData.agama),
                        backgroundColor: '#8b5cf6', // violet-500
                        borderRadius: 6,
                        barThickness: 24,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: 'rgba(15, 23, 42, 0.9)',
                            padding: 12,
                            cornerRadius: 8
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                borderDash: [4, 4],
                                color: '#f1f5f9'
                            },
                            ticks: {
                                precision: 0,
                                color: '#64748b'
                            }
                        },
                        x: {
                            grid: { display: false },
                            ticks: { color: '#64748b' }
                        }
                    }
                }
            });
        }

        // Status Chart (Pie)
        if(chartData.status && Object.keys(chartData.status).length > 0) {
            const statusCtx = document.getElementById('statusChart').getContext('2d');
            
            const statusLabels = Object.keys(chartData.status);
            const statusColors = statusLabels.map(status => {
                const s = status.toUpperCase();
                if (s === 'HIDUP') return '#10b981'; // emerald (green)
                if (s === 'MATI' || s === 'MENINGGAL') return '#f43f5e'; // rose (red)
                if (s === 'PINDAH') return '#f59e0b'; // amber
                return '#64748b'; // slate (fallback)
            });

            new Chart(statusCtx, {
                type: 'doughnut',
                data: {
                    labels: statusLabels,
                    datasets: [{
                        data: Object.values(chartData.status),
                        backgroundColor: statusColors,
                        borderWidth: 0,
                        hoverOffset: 4
                    }]
                },
                options: {
                    ...commonOptions,
                    cutout: '60%',
                    plugins: {
                        ...commonOptions.plugins,
                        tooltip: {
                            backgroundColor: 'rgba(15, 23, 42, 0.9)',
                            padding: 12,
                            cornerRadius: 8
                        }
                    }
                }
            });
        }
    });
</script>
@endpush
