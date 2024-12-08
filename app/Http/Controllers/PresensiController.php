<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Presensi;
use App\Models\PresensiPulang;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Str;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\DB;


class PresensiController extends Controller
{
    public function index()
    {
        if (Auth::user()->role == 'admin') {
            $presensis = DB::table('presensis')
                ->join('presensi_pulangs', function ($join) {
                    $join->on('presensis.nama', '=', 'presensi_pulangs.nama')
                        ->on('presensis.tanggal', '=', 'presensi_pulangs.tanggal')
                        ->on('presensis.jabatan', '=', 'presensi_pulangs.jabatan');
                })
                ->select('presensis.nama', 'presensis.tanggal', 'presensis.jabatan')
                ->groupBy('presensis.nama', 'presensis.tanggal', 'presensis.jabatan')
                ->orderBy('presensis.tanggal', 'desc')
                ->paginate(10);

            $presensisArray = $presensis->items(); // Konversi data paginasi ke array

        } else {
            $presensis = Presensi::where('id_user', Auth::user()->id)
                        ->orderBy('tanggal', 'desc') // Mengurutkan berdasarkan tanggal terbaru
                        ->paginate(10);
        }
        return view('presensi.index', compact('presensis'));
    }


    public function create()
    {
        return view('presensi.create');
    }

    public function search(Request $request)
{
    $query = Presensi::query();

    if ($request->has('search')) {
        $searchTerm = $request->search;

        // Menambahkan kondisi pencarian
        $query->where(function ($q) use ($searchTerm) {
            $q->where('nama', 'like', '%' . $searchTerm . '%')
              ->orWhere('tanggal', 'like', '%' . $searchTerm . '%');
        });
    }

    // Jika pengguna adalah admin, Anda dapat menambahkan logika khusus di sini
    if (auth()->user()->role == 'admin') {
        // Misalnya, jika Anda ingin mengambil data tertentu untuk admin
        $presensi = $query->paginate(10);
    } else {
        // Ambil data untuk pengguna selain admin
        $presensi = $query->where('tanggal', auth()->user()->name)->paginate(10);
    }

    // Menyimpan istilah pencarian saat melakukan paginasi
    $presensi->appends(['search' => $request->search]);

    return view('presensi.index', compact('presensi'))->with('i', (request()->input('page', 1) - 1) * 10);
}

    
    public function store(Request $request)
{
    // Validasi data yang diterima
    $request->validate([
        'photo' => 'required',
        // 'latitude' => 'required',
        // 'longitude' => 'required',
    ]);

    $imageData = $request->photo;
    $now = Carbon::now();
    // $latitude = $request->latitude;
    // $longitude = $request->longitude;

    // Dapatkan lokasi
    // $lokasiData = $this->getLocationFromCoordinates($latitude, $longitude);
    // $lokasi = $lokasiData['location'];

    // Buat instance Presensi
    $presensi = new Presensi();
    $presensi->uuid = Str::uuid();
    $presensi->id_user = Auth::user()->id;
    $presensi->nama = Auth::user()->name;
    $presensi->jabatan = Auth::user()->role;
    $presensi->tanggal = $now->toDateString();
    $presensi->jam = $now->toTimeString();
    // $presensi->latitude = $latitude;
    // $presensi->longitude = $longitude;
    // $presensi->lokasi = $lokasi;

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



// public function getLocationFromCoordinates($latitude, $longitude) {
//     $client = new Client();
//     $apiKey = 'f7315dec454445b09088e332d732f439'; // Ganti dengan API key OpenCage Anda
//     $url = "https://api.opencagedata.com/geocode/v1/json?q={$latitude},{$longitude}&key={$apiKey}&no_annotations=0";

//     try {
//         // Melakukan request ke OpenCage API
//         $response = $client->request('GET', $url, ['timeout' => 5]);

//         if ($response->getStatusCode() !== 200) {
//             Log::error("Error fetching location: HTTP Status Code " . $response->getStatusCode());
//             return [
//                 'location' => "Lokasi yang diambil gagal: HTTP Status Code " . $response->getStatusCode(),
//                 'plus_code' => 'Tidak ada kode Plus',
//             ];
//         }

//         $data = json_decode($response->getBody(), true);

//         if (isset($data['results']) && count($data['results']) > 0) {
//             $result = $data['results'][0];
//             $formattedLocation = $result['formatted'];
//             $components = $result['components'];
//             $plusCode = isset($result['annotations']['plus_code']['global_code']) ? $result['annotations']['plus_code']['global_code'] : null;

//             return [
//                 'location' => "{$formattedLocation}",
//                 'plus_code' => $plusCode,
//             ];
//         } else {
//             Log::error("No results found for coordinates: {$latitude}, {$longitude}");
//             return [
//                 'location' => "Lokasi yang diambil gagal: Tidak ada hasil ditemukan",
//                 'plus_code' => 'Tidak ada kode Plus',
//             ];
//         }
//     } catch (RequestException $e) {
//         Log::error("Error fetching location: {$latitude}, {$longitude} - " . $e->getMessage());
//         return [
//             'location' => "Lokasi yang diambil gagal: Terjadi kesalahan pada API",
//             'plus_code' => 'Tidak ada kode Plus',
//         ];
//     } catch (\Exception $e) {
//         Log::error("Unexpected error fetching location: {$latitude}, {$longitude} - " . $e->getMessage());
//         return [
//             'location' => "Lokasi yang diambil gagal: Terjadi kesalahan pada API",
//             'plus_code' => 'Tidak ada kode Plus',
//         ];
//     }
// }

public function show($nama, $tanggal)
{
    // Ambil semua entri presensi berdasarkan nama dan tanggal
    $dataPresensi = Presensi::where('nama', $nama)
        ->where('tanggal', $tanggal)
        ->get();

    // Ambil semua entri dari tabel presensi_pulang berdasarkan nama dan tanggal
    $dataPresensiPulang = PresensiPulang::where('nama', $nama)
        ->where('tanggal', $tanggal)
        ->get();

    // Pastikan ada data yang ditemukan di salah satu atau kedua tabel
    if ($dataPresensi->isEmpty() && $dataPresensiPulang->isEmpty()) {
        return redirect()->route('presensi.index')->with('error', 'Data presensi tidak ditemukan!');
    }

    // Kirimkan kedua data ke view
    return view('presensi.show', compact('dataPresensi', 'dataPresensiPulang'));
}



public function delete($nama, $tanggal)
{
    // Menghapus semua entri presensi berdasarkan nama dan tanggal
    Presensi::where('nama', $nama)
        ->where('tanggal', $tanggal)
        ->delete();

    // Menghapus semua entri presensi_pulang berdasarkan nama dan tanggal
    PresensiPulang::where('nama', $nama)
        ->where('tanggal', $tanggal)
        ->delete();
    
    return redirect()->back()->with('success', 'Data berhasil dihapus');
}

}




