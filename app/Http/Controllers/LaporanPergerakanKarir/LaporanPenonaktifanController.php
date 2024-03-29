<?php

namespace App\Http\Controllers\LaporanPergerakanKarir;

use App\Http\Controllers\Controller;
use App\Service\EntityService;
use Illuminate\Http\Request;
use App\Repository\KaryawanRepository;
use Illuminate\Support\Facades\DB;

class LaporanPenonaktifanController extends Controller
{
    public function index(Request $request) {
        $data = null;
        $start_date = $request->start_date;
        $end_date = $request->end_date;

        $karyawanRepo = new KaryawanRepository();

        if($start_date && $end_date){
            $data = $karyawanRepo->filterKaryawanPusatNonaktif($start_date, $end_date);
        }
        return view('laporan_pergerakan_karir.penonaktifan.index', compact('data'));
    }
}
