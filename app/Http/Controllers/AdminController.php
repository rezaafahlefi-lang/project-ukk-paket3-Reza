<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\InputAspirasi;
use App\Models\Aspirasi;
use App\Models\Kategori;

class AdminController extends Controller
{
    // Menampilkan halaman dashboard admin beserta fitur filter
    public function index(Request $request)
    {
        // Menggunakan Query Builder dengan JOIN sesuai kebutuhan relasi
        $query = InputAspirasi::join('aspirasis', 'input_aspirasis.id_pelaporan', '=', 'aspirasis.id_pelaporan')
            ->join('kategoris', 'input_aspirasis.id_kategori', '=', 'kategoris.id_kategori')
            ->select(
                'input_aspirasis.*', 
                'aspirasis.id_aspirasi', 
                'aspirasis.status', 
                'aspirasis.feedback', 
                'kategoris.ket_kategori'
            );

        // Filter per Tanggal
        if ($request->filled('tanggal')) {
            $query->whereDate('input_aspirasis.created_at', $request->tanggal);
        }
        // Filter per Bulan
        if ($request->filled('bulan')) {
            $query->whereMonth('input_aspirasis.created_at', $request->bulan);
        }
        // Filter per Siswa (NIS)
        if ($request->filled('nis')) {
            $query->where('input_aspirasis.nis', $request->nis);
        }
        // Filter per Kategori
        if ($request->filled('id_kategori')) {
            $query->where('input_aspirasis.id_kategori', $request->id_kategori);
        }

        $aspirasis = $query->orderBy('input_aspirasis.created_at', 'desc')->get();
        $kategoris = Kategori::all();

        return view('admin.dashboard', compact('aspirasis', 'kategoris'));
    }

    // Prosedur untuk memperbarui status dan feedback
    public function update(Request $request, $id_aspirasi)
    {
        $request->validate([
            'status' => 'required|in:Menunggu,Proses,Selesai',
            'feedback' => 'nullable|string|max:255',
        ]);

        // Cari data di tabel aspirasis berdasarkan primary key
        $aspirasi = Aspirasi::findOrFail($id_aspirasi);
        
        $aspirasi->update([
            'status' => $request->status,
            'feedback' => $request->feedback
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'Status dan umpan balik berhasil diperbarui.');
    }

    // Prosedur untuk menambah kategori sarana baru
    public function storeKategori(Request $request)
    {
        $request->validate([
            'ket_kategori' => 'required|string|max:30',
        ]);

        Kategori::create([
            'ket_kategori' => $request->ket_kategori
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'Kategori sarana baru berhasil ditambahkan.');
    }

    // Prosedur untuk menghapus data laporan (Delete)
    public function destroy($id_pelaporan)
    {
        // Mencari laporan berdasarkan ID pelaporan
        $laporan = InputAspirasi::findOrFail($id_pelaporan);
        
        // Menghapus laporan (otomatis menghapus status dan feedback berkat cascade)
        $laporan->delete();

        return redirect()->route('admin.dashboard')->with('success', 'Data laporan berhasil dihapus.');
    }
}