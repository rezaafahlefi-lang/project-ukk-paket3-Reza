@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')

<!-- Menampilkan Pesan Sukses -->
@if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6 text-sm shadow-sm relative" role="alert">
        <span class="block sm:inline">{{ session('success') }}</span>
    </div>
@endif

<!-- Bagian 1: Filter Laporan Aspirasi -->
<div class="bg-white p-6 border border-gray-200 rounded-lg shadow-sm mb-6">
    <h3 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">Filter Laporan Aspirasi</h3>
    
    <form action="{{ route('admin.dashboard') }}" method="GET" class="grid grid-cols-1 md:grid-cols-5 gap-4 items-end">
        <div>
            <label class="block text-xs font-medium text-gray-700 mb-1">Per Tanggal</label>
            <input type="date" name="tanggal" value="{{ request('tanggal') }}" class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:ring-blue-500 focus:border-blue-500 outline-none">
        </div>
        <div>
            <label class="block text-xs font-medium text-gray-700 mb-1">Per Bulan (Angka 1-12)</label>
            <input type="number" name="bulan" min="1" max="12" value="{{ request('bulan') }}" class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:ring-blue-500 outline-none" placeholder="Contoh: 9">
        </div>
        <div>
            <label class="block text-xs font-medium text-gray-700 mb-1">Per Siswa (NIS)</label>
            <input type="text" name="nis" value="{{ request('nis') }}" class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:ring-blue-500 outline-none" placeholder="Ketik NIS">
        </div>
        <div>
            <label class="block text-xs font-medium text-gray-700 mb-1">Per Kategori</label>
            <select name="id_kategori" class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:ring-blue-500 outline-none">
                <option value="">Semua Kategori</option>
                @foreach($kategoris as $k)
                    <option value="{{ $k->id_kategori }}" {{ request('id_kategori') == $k->id_kategori ? 'selected' : '' }}>
                        {{ $k->ket_kategori }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="flex space-x-2">
            <button type="submit" class="w-full bg-blue-600 text-white font-bold py-2 rounded-md hover:bg-blue-700 transition duration-150 text-sm">Filter</button>
            <a href="{{ route('admin.dashboard') }}" class="w-full text-center bg-gray-500 text-white font-bold py-2 rounded-md hover:bg-gray-600 transition duration-150 text-sm">Reset</a>
        </div>
    </form>
</div>

<!-- Bagian 2: Tabel Keseluruhan Laporan -->
<div class="bg-white p-6 border border-gray-200 rounded-lg shadow-sm overflow-x-auto">
    <h3 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">Daftar Aspirasi Masuk</h3>
    
    <table class="min-w-full divide-y divide-gray-200 text-sm">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pelapor (NIS)</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kategori & Lokasi</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Keterangan</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider min-w-50">Aksi (Umpan Balik)</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @forelse($aspirasis as $a)
            <tr class="hover:bg-gray-50 transition duration-150">
                <td class="px-4 py-4 whitespace-nowrap text-gray-600">{{ $a->created_at->format('d/m/Y H:i') }}</td>
                <td class="px-4 py-4 font-bold text-gray-800">{{ $a->nis }}</td>
                <td class="px-4 py-4">
                    <span class="block text-xs font-bold text-blue-600 uppercase">{{ $a->ket_kategori }}</span>
                    <span class="text-gray-700">{{ $a->lokasi }}</span>
                </td>
                <td class="px-4 py-4 text-gray-700">{{ $a->ket }}</td>
                <td class="px-4 py-4 bg-gray-50 rounded-lg">
                    
                    <!-- Form untuk memberikan umpan balik dan update status (U) -->
                    <form action="{{ route('admin.aspirasi.update', $a->id_aspirasi) }}" method="POST" class="flex flex-col space-y-2 mb-2">
                        @csrf
                        <select name="status" class="px-2 py-1 border border-gray-300 rounded text-xs focus:outline-none focus:border-blue-500">
                            <option value="Menunggu" {{ $a->status == 'Menunggu' ? 'selected' : '' }}>Menunggu</option>
                            <option value="Proses" {{ $a->status == 'Proses' ? 'selected' : '' }}>Proses</option>
                            <option value="Selesai" {{ $a->status == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                        </select>
                        <textarea name="feedback" rows="1" class="px-2 py-1 border border-gray-300 rounded text-xs w-full focus:outline-none focus:border-blue-500" placeholder="Beri umpan balik...">{{ $a->feedback }}</textarea>
                        <button type="submit" class="bg-green-600 text-white text-xs py-1 rounded hover:bg-green-700 transition duration-150">Simpan Perubahan</button>
                    </form>

                    <!-- Form untuk menghapus laporan (D) -->
                    <form action="{{ route('admin.aspirasi.destroy', $a->id_pelaporan) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus laporan ini secara permanen?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full bg-red-600 text-white text-xs py-1 rounded hover:bg-red-700 transition duration-150">Hapus Laporan</button>
                    </form>

                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="px-4 py-8 text-center text-gray-500">
                    <div class="flex flex-col items-center justify-center">
                        <svg class="h-10 w-10 text-gray-300 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                        </svg>
                        <span>Tidak ada data laporan ditemukan.</span>
                    </div>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection