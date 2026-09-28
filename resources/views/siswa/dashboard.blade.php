@extends('layouts.app')

@section('title', 'Dashboard Siswa')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    
    <!-- Bagian Form Input Aspirasi -->
    <div class="bg-white p-6 border border-gray-200 rounded-lg shadow-sm h-fit">
        <h3 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">Buat Pengaduan</h3>
        
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4 text-sm">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('siswa.aspirasi.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Kategori Sarana</label>
                <select name="id_kategori" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 outline-none" required>
                    <option value="">-- Pilih Kategori --</option>
                    @foreach($kategoris as $k)
                        <option value="{{ $k->id_kategori }}">{{ $k->ket_kategori }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Lokasi (Maks 50 Karakter)</label>
                <input type="text" name="lokasi" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 outline-none" placeholder="Contoh: Lab Komputer 1" required maxlength="50">
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Keterangan / Masalah</label>
                <textarea name="ket" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 outline-none" placeholder="Contoh: AC bocor menetes ke meja" required maxlength="50"></textarea>
            </div>

            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-md transition">
                Kirim Pengaduan
            </button>
        </form>
    </div>

    <!-- Bagian Histori dan Status Aspirasi -->
    <div class="md:col-span-2 bg-white p-6 border border-gray-200 rounded-lg shadow-sm overflow-x-auto">
        <h3 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">Histori & Status Laporan Saya</h3>
        
        <table class="min-w-full divide-y divide-gray-200 text-sm">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Lokasi</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Keterangan</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Umpan Balik (Admin)</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($historis as $h)
                <tr>
                    <td class="px-4 py-3 whitespace-nowrap">{{ $h->created_at->format('d/m/Y H:i') }}</td>
                    <td class="px-4 py-3">{{ $h->lokasi }}</td>
                    <td class="px-4 py-3">{{ $h->ket }}</td>
                    <td class="px-4 py-3">
                        @if($h->status == 'Menunggu')
                            <span class="px-2 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs font-bold">Menunggu</span>
                        @elseif($h->status == 'Proses')
                            <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded-full text-xs font-bold">Diproses</span>
                        @else
                            <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs font-bold">Selesai</span>
                        @endif
                    </td>
                    <td class="px-4 py-3 text-gray-600">
                        {{ $h->feedback ?? 'Belum ada tanggapan' }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-4 py-6 text-center text-gray-500">Belum ada aspirasi yang dikirim.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection