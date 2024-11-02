<?php
namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use App\Models\DataKarywan;
use Illuminate\Http\Request;
use App\Models\Presensi;

class ExportDataController extends Controller
{
    public function presensi($startDate, $endDate){
        $presensi = Presensi::whereBetween('created_at', [$startDate, $endDate])->get();
        return response()->json($presensi);
    }
    
}
