<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Aplikasi Pengaduan Sarana')</title>
    <!-- Memanggil Tailwind CSS via CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 text-gray-800 font-sans antialiased">

    <!-- Navbar -->
    <nav class="bg-blue-600 shadow-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <span class="text-white font-bold text-xl tracking-wide">Aspirasi Sekolah</span>
                </div>
                <div class="flex items-center space-x-4">
                    @if(Auth::guard('admin')->check())
                        <span class="text-blue-100 text-sm">Admin: {{ Auth::guard('admin')->user()->username }}</span>
                    @elseif(Auth::guard('siswa')->check())
                        <span class="text-blue-100 text-sm">Siswa: {{ Auth::guard('siswa')->user()->nis }}</span>
                    @endif
                    
                    @if(Auth::guard('admin')->check() || Auth::guard('siswa')->check())
                        <form action="{{ route('logout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="text-white hover:bg-blue-700 px-3 py-2 rounded-md text-sm font-medium transition duration-150">
                                Logout
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <!-- Konten Utama -->
    <main class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        @yield('content')
    </main>

</body>
</html>