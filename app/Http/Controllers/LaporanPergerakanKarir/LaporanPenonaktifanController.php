<?php

namespace App\Http\Controllers\LaporanPergerakanKarir;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LaporanPenonaktifanController extends Controller
{
    public function index(Request $request) {
        return view('laporan_pergerakan_karir.penonaktifan.index');
    }
}