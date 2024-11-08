<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Presensi;
use App\Models\PresensiPulang;
use Illuminate\Http\Request;

class ExportDataController extends Controller
{
    public function absen($startDate, $endDate){
        $rekap_presensi = Presensi::whereBetween('created_at', [$startDate, $endDate])->get();
        return response()->json($rekap_presensi);
    }

    public function absenpulang($startDate, $endDate){
        $presensi_pulang = PresensiPulang::whereBetween('created_at', [$startDate, $endDate])->get();
        return response()->json($presensi_pulang);
    }
}
