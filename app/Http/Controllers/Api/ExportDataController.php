<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Presensi;
use Illuminate\Http\Request;

class ExportDataController extends Controller
{
    public function absen($startDate, $endDate){
        $rekap_presensi = Presensi::whereBetween('created_at', [$startDate, $endDate])->get();
        return response()->json($rekap_presensi);
    }
}
