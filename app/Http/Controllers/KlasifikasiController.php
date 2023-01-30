<?php

namespace App\Http\Controllers;

use App\Models\JabatanModel;
use App\Models\KaryawanModel;
use App\Models\PanggolModel;
use App\Service\ClassificationService;
use App\Service\EntityService;
use Doctrine\DBAL\Query;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KlasifikasiController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $jabatan = JabatanModel::all();
        $panggol = PanggolModel::all();

        return view('karyawan.klasifikasi', [
            'karyawan' => null,
            'status' => null,
            'jabatan' => $jabatan,
            'panggol' => $panggol,
        ]);
    }

    public function klasifikasi_data(Request $request)
    {
        $kantor = $request->kantor;
        $karyawan = collect();
        $status = 0;

        $jabatan = JabatanModel::all();
        $panggol = PanggolModel::all();

        if ($request->kategori == 1) {
            $karyawan = KaryawanModel::query();

            $status = 1;
        }

        if ($request->kategori == 2) {
            $subDivs = DB::table('mst_sub_divisi')->where('kd_divisi', $request->divisi)
                ->pluck('kd_subdiv');

            $bagians = DB::table('mst_bagian')->whereIn('kd_entitas', $subDivs)
                ->orWhere('kd_entitas', $request->divisi)
                ->pluck('kd_bagian');

            $karyawan = KaryawanModel::where('kd_entitas', $request->divisi)
                ->orWhereIn('kd_entitas', $subDivs)
                ->orWhereIn('kd_bagian', $bagians);

            $status = 2;
        }

        if ($request->kategori == 3) {
            $entitas = $request->subDivisi ?? $request->divisi;

            $bagian = DB::table('mst_bagian')->where('kd_entitas', $entitas)
                ->pluck('kd_bagian');

            $karyawan = KaryawanModel::where('kd_entitas', $entitas)
                ->orWhereIn('kd_bagian', $bagian);

            $status = 3;
        }

        if ($request->kategori == 4) {
            $karyawan = KaryawanModel::where('kd_bagian', $request->bagian)->whereNotNull('kd_bagian');
            $status = 4;
        }

        if ($request->kategori == 5) {
            if ($kantor == 'Cabang') $karyawan = KaryawanModel::where('kd_entitas', $request->cabang);

            if ($kantor == 'Pusat') {
                $cbgs = DB::table('mst_cabang')->pluck('kd_cabang');
                $karyawan = KaryawanModel::whereNotIn('kd_entitas', $cbgs)
                    ->orWhere('kd_entitas', null);
            }

            $status = 5;
        }

        if ($request->kategori == 6) {
            // Get data karyawan dengan tunjangan
            $karyawan = KaryawanModel::with('tunjangan');
            // Get data karyawan pertama
            $karyawan = $karyawan->first();
            $totalTunjangan = 0;

            // Uncomment kode berikut untuk melihat struktur data
            dd($karyawan->toArray());

            // Menjumlahkan seluruh nominal tunjangan pada karyawan
            $karyawan->tunjangan->map(function ($tj) use (&$totalTunjangan) {
                $totalTunjangan += $tj->pivot->nominal;
            });

            // Total gaji pokok ditambah dengan tunjangan
            dd($karyawan->gj_pokok + $totalTunjangan);
        }

        if ($request->kategori == 9) {
            $karyawan = KaryawanModel::where('mst_karyawan.kd_jabatan', $request->jabatan);

            $status = 9;
        }

        if ($request->kategori == 10) {
            $karyawan = KaryawanModel::where('mst_karyawan.kd_panggol', $request->panggol);

            $status = 10;
        }

        if ($request->kategori == 11) {
            $karyawan = KaryawanModel::where('mst_karyawan.status_karyawan', $request->status);

            $status = 11;
        }

        if ($karyawan instanceof Builder) {
            $karyawan->leftJoin('is', 'is.id', 'mst_karyawan.id_is');
            $karyawan->leftJoin('mst_jabatan', 'mst_jabatan.kd_jabatan', 'mst_karyawan.kd_jabatan');
            $karyawan = $karyawan->get();
        }

        return view('karyawan.klasifikasi', [
            'status' => $status,
            'karyawan' => $karyawan,
            'jabatan' => $jabatan,
            'panggol' => $panggol,
            'request' => $request,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
