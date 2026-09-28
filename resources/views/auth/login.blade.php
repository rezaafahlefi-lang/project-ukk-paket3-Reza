@extends('layouts.app')

@section('title', 'Login - Aspirasi Sekolah')

@section('content')
<div class="max-w-md mx-auto bg-white p-8 border border-gray-200 rounded-lg shadow-sm mt-10">
    <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">Masuk ke Sistem</h2>
    
    <!-- Menampilkan pesan error jika login gagal -->
    @if($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ $errors->first() }}</span>
        </div>
    @endif

    <!-- Form action mengarah ke route login -->
    <form action="{{ route('login') }}" method="POST">
        @csrf
        
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">Username / NIS</label>
            <input type="text" name="username" value="{{ old('username') }}" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500 outline-none transition" required autofocus>
        </div>

        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
            <input type="password" name="password" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500 outline-none transition" required>
        </div>

        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-md transition duration-150">
            Login
        </button>
    </form>
</div>
@endsection