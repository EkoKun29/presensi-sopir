<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Presensi;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\User;

class PresensiController extends Controller
{
    public function index()
    {
        $presensis = Presensi::all();
        return view('presensi.index', compact('presensis'));
    }

    public function create()
    {
        return view('presensi.create');
    }

    public function store(Request $request)
{
    $request->validate([
        'face' => 'required',
        'nama' => 'required',
        'jabaran' => 'required',
        'tanggal' => 'required|date',
        'jam' => 'required',
        'latitude' => 'required', // Validasi latitude
        'longitude' => 'required', // Validasi longitude
    ]);

    // Decode base64 image
    $imageData = $request->face;

    // Buat instance Presensi terlebih dahulu agar UUID otomatis dihasilkan
    $presensi = new Presensi([
        'id_user' => Auth::user()->id,
        'nama' => Auth::user()->name,
        'jabatan' => Auth::user()->jabatan,
        'tanggal' => $request->tanggal,
        'jam' => $request->jam,
        'latitude' => $request->latitude, // Menyimpan latitude
        'longitude' => $request->longitude, // Menyimpan longitude
    ]);

    // Simpan image dengan nama UUID
    $fileName = $presensi->uuid . '.png'; // Menggunakan UUID yang sudah di-generate oleh model
    $imagePath = 'faces/' . $fileName;

    // Simpan image dari base64 ke storage
    $image = str_replace('data:image/png;base64,', '', $imageData);
    $image = str_replace(' ', '+', $image);
    Storage::disk('public')->put($imagePath, base64_decode($image));

    // Simpan path gambar ke database
    $presensi->face = $imagePath;
    $presensi->save(); // Simpan data presensi dengan path gambar yang sudah diupdate

    return redirect()->route('presensi.index')->with('success', 'Presensi berhasil disimpan!');
}

}
