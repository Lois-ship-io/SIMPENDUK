@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-50/50 py-12 px-4 sm:px-6 lg:px-8 selection:bg-blue-100 selection:text-blue-900">
    <div class="max-w-[400px] w-full bg-white p-8 sm:p-10 rounded-2xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100">
        
        <div class="mb-8 text-center">
            <h1 class="text-3xl font-black tracking-tight">
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-indigo-600">SIMPENDUK</span>
            </h1>
            <p class="mt-1.5 text-[12px] font-bold text-gray-500 uppercase tracking-[0.2em]">
                Sistem Manajemen Penduduk
            </p>
            
            <div class="mt-10 relative flex items-center justify-center">
                <div class="absolute inset-x-0 h-px bg-gradient-to-r from-transparent via-gray-300 to-transparent"></div>
                <div class="relative bg-white px-5">
                    <span class="text-[15px] font-black text-gray-800 tracking-widest uppercase">LOGIN</span>
                </div>
            </div>
        </div>

        <form class="space-y-5" action="{{ route('login') }}" method="POST">
            @csrf
            
            @if($errors->any())
                <div class="p-4 rounded-xl bg-red-50 border border-red-100 flex items-start mb-2">
                    <svg class="h-5 w-5 text-red-500 mt-0.5 mr-3 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <p class="text-[13px] font-medium text-red-800">{{ $errors->first() }}</p>
                </div>
            @endif

            <div class="space-y-1.5">
                <label for="email" class="block text-[13px] font-semibold text-gray-700">Email address</label>
                <div class="relative">
                    <input id="email" name="email" type="email" autocomplete="email" required class="block w-full py-2.5 px-3.5 rounded-xl text-[14px] {{ $errors->has('email') ? 'border-red-300 focus:border-red-500 focus:ring-red-500/20' : 'border-gray-300 focus:border-blue-500 focus:ring-blue-500/20' }} text-gray-900 placeholder-gray-400 focus:ring-4 transition-all duration-200 outline-none border shadow-sm" placeholder="" value="{{ old('email') }}">
                </div>
            </div>

            <div class="space-y-1.5" x-data="{ show: false }">
                <label for="password" class="block text-[13px] font-semibold text-gray-700">Password</label>
                <div class="relative">
                    <input :type="show ? 'text' : 'password'" id="password" name="password" autocomplete="current-password" required class="block w-full py-2.5 pl-3.5 pr-10 rounded-xl text-[14px] {{ $errors->has('email') ? 'border-red-300 focus:border-red-500 focus:ring-red-500/20' : 'border-gray-300 focus:border-blue-500 focus:ring-blue-500/20' }} text-gray-900 placeholder-gray-400 focus:ring-4 transition-all duration-200 outline-none border shadow-sm" placeholder="••••••••">
                    <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600 focus:outline-none transition-colors">
                        <svg x-show="!show" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        <svg x-show="show" style="display:none;" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a10.05 10.05 0 011.51-3.14m2.164-2.164A9.97 9.97 0 0112 5c4.478 0 8.268 2.943 9.542 7a10.06 10.06 0 01-2.16 3.14M15 12a3 3 0 01-3 3m-3-3a3 3 0 013-3m0 0L2 2l20 20" />
                        </svg>
                    </button>
                </div>
            </div>

            <div class="flex items-center pt-1.5 pb-1.5">
                <input id="remember-me" name="remember" type="checkbox" class="h-4 w-4 text-blue-600 focus:ring-blue-500/30 border-gray-300 rounded focus:ring-2 focus:ring-offset-0 cursor-pointer transition-colors duration-200">
                <label for="remember-me" class="ml-2.5 block text-[13px] font-medium text-gray-600 cursor-pointer select-none">
                    Remember me
                </label>
            </div>

            <div class="pt-2">
                <button type="submit" class="w-full flex justify-center items-center py-2.5 px-4 border border-transparent rounded-xl shadow-sm text-[14px] font-semibold text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-500/30 transition-all duration-200 active:scale-[0.98]">
                    Login
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
