<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Kategori;
use App\Models\InputAspirasi;
use App\Models\Aspirasi;

class SiswaController extends Controller
{
    // Fungsi untuk menampilkan halaman dashboard siswa
    public function index()
    {
        $kategoris = Kategori::all();
        $nis = Auth::guard('siswa')->user()->nis;

        // Mengambil histori dan status penyelesaian menggunakan Join
        $historis = InputAspirasi::join('aspirasis', 'input_aspirasis.id_pelaporan', '=', 'aspirasis.id_pelaporan')
                    ->where('input_aspirasis.nis', $nis)
                    ->orderBy('input_aspirasis.created_at', 'desc')
                    ->get(['input_aspirasis.*', 'aspirasis.status', 'aspirasis.feedback']);

        return view('siswa.dashboard', compact('kategoris', 'historis'));
    }

    // Prosedur untuk menyimpan data aspirasi
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'id_kategori' => 'required',-
            'lokasi' => 'required|max:50',
            'ket' => 'required|max:50',
        ]);

        // Penggunaan ARRAY untuk menyusun data sebelum disimpan (Sesuai Syarat Soal)
        $dataInput = [
            'nis' => Auth::guard('siswa')->user()->nis,
            'id_kategori' => $request->id_kategori,
            'lokasi' => $request->lokasi,
            'ket' => $request->ket,
        ];

        // Simpan ke tabel input_aspirasis
        $input = InputAspirasi::create($dataInput);

        // Buat data awal di tabel aspirasis dengan status 'Menunggu'
        Aspirasi::create([
            'id_pelaporan' => $input->id_pelaporan,
            'id_kategori' => $request->id_kategori,
            'status' => 'Menunggu',
        ]);

        return redirect()->route('siswa.dashboard')->with('success', 'Aspirasi berhasil dikirim dan sedang menunggu proses.');
    }
}