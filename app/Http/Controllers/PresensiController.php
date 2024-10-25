<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Presensi;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Str;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Exception\RequestException;


class PresensiController extends Controller
{
    public function index()
    {
        if (Auth::user()->role == 'admin') {
            $presensis = Presensi::select('nama', 'tanggal', 'jabatan')
                        ->groupBy('nama', 'tanggal', 'jabatan')
                        ->paginate(10);
        }else{
            $presensis = Presensi::where('id_user', Auth::user()->id)->paginate('10');
        }
        return view('presensi.index', compact('presensis'));
    }

    public function create()
    {
        return view('presensi.create');
    }

    public function store(Request $request)
{
    // Validasi data yang diterima
    $request->validate([
        'photo' => 'required',
        'latitude' => 'required',
        'longitude' => 'required',
    ]);

    $imageData = $request->photo;
    $now = Carbon::now();
    $latitude = $request->latitude;
    $longitude = $request->longitude;

    // Dapatkan lokasi
    $lokasiData = $this->getLocationFromCoordinates($latitude, $longitude);
    $lokasi = $lokasiData['location'];

    // Buat instance Presensi
    $presensi = new Presensi();
    $presensi->uuid = Str::uuid();
    $presensi->id_user = Auth::user()->id;
    $presensi->nama = Auth::user()->name;
    $presensi->jabatan = Auth::user()->role;
    $presensi->tanggal = $now->toDateString();
    $presensi->jam = $now->toTimeString();
    $presensi->latitude = $latitude;
    $presensi->longitude = $longitude;
    $presensi->lokasi = $lokasi;

    // Proses penyimpanan gambar
    $fileName = $presensi->uuid . '.png'; // Nama file
    $imagePath = 'public/' . $fileName; // Path untuk disimpan di storage
    $image = str_replace('data:image/png;base64,', '', $imageData);
    $image = str_replace(' ', '+', $image);

    // Simpan gambar di storage/app/public
    Storage::put($imagePath, base64_decode($image)); // Simpan gambar

    // Simpan nama file ke database
    $presensi->face = $fileName; // Simpan hanya nama file
    $presensi->save();

    return redirect()->route('presensi.index')->with('success', 'Presensi berhasil disimpan!');
}



public function getLocationFromCoordinates($latitude, $longitude) {
    $client = new Client();
    $apiKey = 'f7315dec454445b09088e332d732f439'; // Ganti dengan API key OpenCage Anda
    $url = "https://api.opencagedata.com/geocode/v1/json?q={$latitude},{$longitude}&key={$apiKey}&no_annotations=0";

    try {
        // Melakukan request ke OpenCage API
        $response = $client->request('GET', $url, ['timeout' => 5]);

        if ($response->getStatusCode() !== 200) {
            Log::error("Error fetching location: HTTP Status Code " . $response->getStatusCode());
            return [
                'location' => "Lokasi yang diambil gagal: HTTP Status Code " . $response->getStatusCode(),
                'plus_code' => 'Tidak ada kode Plus',
            ];
        }

        $data = json_decode($response->getBody(), true);

        if (isset($data['results']) && count($data['results']) > 0) {
            $result = $data['results'][0];
            $formattedLocation = $result['formatted'];
            $components = $result['components'];
            $plusCode = isset($result['annotations']['plus_code']['global_code']) ? $result['annotations']['plus_code']['global_code'] : null;

            return [
                'location' => "{$formattedLocation}",
                'plus_code' => $plusCode,
            ];
        } else {
            Log::error("No results found for coordinates: {$latitude}, {$longitude}");
            return [
                'location' => "Lokasi yang diambil gagal: Tidak ada hasil ditemukan",
                'plus_code' => 'Tidak ada kode Plus',
            ];
        }
    } catch (RequestException $e) {
        Log::error("Error fetching location: {$latitude}, {$longitude} - " . $e->getMessage());
        return [
            'location' => "Lokasi yang diambil gagal: Terjadi kesalahan pada API",
            'plus_code' => 'Tidak ada kode Plus',
        ];
    } catch (\Exception $e) {
        Log::error("Unexpected error fetching location: {$latitude}, {$longitude} - " . $e->getMessage());
        return [
            'location' => "Lokasi yang diambil gagal: Terjadi kesalahan pada API",
            'plus_code' => 'Tidak ada kode Plus',
        ];
    }
}

public function show($nama, $tanggal)
    {
        // Ambil semua entri presensi berdasarkan nama dan tanggal
        $dataPresensi = Presensi::where('nama', $nama)
            ->where('tanggal', $tanggal)
            ->get();

        // Pastikan ada data yang ditemukan
        if ($dataPresensi->isEmpty()) {
            return redirect()->route('presensi.index')->with('error', 'Data presensi tidak ditemukan!');
        }

        return view('presensi.show', compact('dataPresensi'));
    }

    public function search(Request $request)
    {
        if ($request->has('search')) {
            $searchTerm = $request->search;

            $presensi = Presensi::where(function ($query) use ($searchTerm) {
                $query->where('nama', 'like', '%' . $searchTerm . '%')
                ->orWhere('tanggal', 'like', '%' . $searchTerm . '%');
            })
            ->paginate(10);

            // Keep the search term when paginating
            $presensi->appends(['search' => $searchTerm]);
        } else {

        }

        return view('presensi.index', compact('presensi'))->with('i', (request()->input('page', 1) - 1) * 10);
    }


}




