<?php

namespace App\Http\Controllers;

use App\Imports\PenghasilanImport;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use RealRashid\SweetAlert\Facades\Alert;

class PenghasilanTidakTeraturController extends Controller
{
    public function getDataKaryawan(Request $request)
    {
        $nip = $request->get('nip');
        $data = DB::table('mst_karyawan')
            ->where('nip', $nip)
            ->join('mst_jabatan', 'mst_jabatan.kd_jabatan', '=', 'mst_karyawan.kd_jabatan')
            ->select('mst_karyawan.*', 'mst_jabatan.nama_jabatan')
            ->first();
        if($data == null){
            return null;
        }
        if($data->status_karyawan == "Tetap"){
            $jabatan = "Pegawai ".$data->status_karyawan . ' ' . $data->nama_jabatan;
        }
        else{
            $jabatan = $data->status_karyawan . ' ' . $data->nama_jabatan;
        }
        $dk = [
            'nip' => $data->nip,
            'nama' => $data->nama_karyawan,
            'jabatan' => $jabatan
        ];

        return response()->json($dk);
    }

    public function upload(Request $request)
    {
        $file = $request->file('upload_csv');
        $import = new PenghasilanImport;
        $row = Excel::toArray($import, $file);
        // dd(count($row[0]));
        $import = $import->import($file);
        Alert::success('Berhasil', 'Berhasil mengimport '.count($row[0]).' data');
        return redirect()->route('penghasilan.index');
    }

    public function filter(Request $request)
    {
        $tahun = $request->get('tahun');
        $mode = $request->get('mode');
        $nip = $request->get('nip');
        $gaji = array();
        $total_gaji = array();
        $tk = array();
        $ptt = array();
        $bonus = array();
        $total_gj = array();
        $jamsostek = array();
        $tj = [];
        $peng = [];
        $bon = [];
        $w = 0;
        $x = 0;
        $y = 0;
        $z = 0;

        $karyawan = DB::table('mst_karyawan')
            ->where(compact('nip'))
            ->join('mst_jabatan', 'mst_jabatan.kd_jabatan', '=', 'mst_karyawan.kd_jabatan')
            ->select('mst_karyawan.*', 'mst_jabatan.nama_jabatan')
            ->first();

        // Get gaji secara bulanan
        for($i = 1; $i <= 12; $i++){
            $data = DB::table('gaji_per_bulan')
                ->where('nip', $nip)
                ->where('bulan', $i)
                ->where('tahun', $tahun)
                ->first();
            $tj_trans =  DB::table('penghasilan_tidak_teratur')
                ->where('nip', $nip)
                ->where('id_tunjangan', 11)
                ->where('tahun', $tahun)
                ->where('bulan', $i)
                ->first();
            $tj_pulsa =  DB::table('penghasilan_tidak_teratur')
                ->where('nip', $nip)
                ->where('id_tunjangan', 12)
                ->where('tahun', $tahun)
                ->where('bulan', $i)
                ->first();
            $tj_vitamin =  DB::table('penghasilan_tidak_teratur')
                ->where('nip', $nip)
                ->where('id_tunjangan', 13)
                ->where('tahun', $tahun)
                ->where('bulan', $i)
                ->first();
            $tj_uang_makan =  DB::table('penghasilan_tidak_teratur')
                ->where('nip', $nip)
                ->where('id_tunjangan', 14)
                ->where('tahun', $tahun)
                ->where('bulan', $i)
                ->first();
           $gj[$i - 1] = [
            'gj_pokok' => ($data != null) ? $data->gj_pokok : 0,
            'gj_penyesuaian' => ($data != null) ? $data->gj_penyesuaian : 0,
            'tj_keluarga' => ($data != null) ? $data->tj_keluarga : 0,
            'tj_telepon' => ($data != null) ? $data->tj_telepon : 0,
            'tj_jabatan' => ($data != null) ? $data->tj_jabatan : 0,
            'tj_teller' => ($data != null) ? $data->tj_teller : 0,
            'tj_perumahan' => ($data != null) ? $data->tj_perumahan : 0,
            'tj_kemahalan' => ($data != null) ? $data->tj_kemahalan : 0,
            'tj_pelaksana' => ($data != null) ? $data->tj_pelaksana : 0,
            'tj_kesejahteraan' => ($data != null) ? $data->tj_kesejahteraan : 0,
            'tj_multilevel' => ($data != null) ? $data->tj_multilevel : 0,
            'tj_ti' => ($data != null) ? $data->tj_ti : 0,
            'tj_transport' => ($tj_trans != null && $data != null) ? $tj_trans->nominal : 0,
            'tj_pulsa' => ($tj_pulsa != null && $data != null) ? $tj_pulsa->nominal : 0,
            'tj_vitamin' => ($tj_vitamin != null && $data != null) ? $tj_vitamin->nominal : 0,
            'uang_makan' => ($tj_uang_makan != null && $data != null) ? $tj_uang_makan->nominal : 0,
           ];

           $total_gj[$i-1] = [
            'gj_pokok' => ($data != null) ? $data->gj_pokok : 0,
            'gj_penyesuaian' => ($data != null) ? $data->gj_penyesuaian : 0,
            'tj_keluarga' => ($data != null) ? $data->tj_keluarga : 0,
            'tj_telepon' => ($data != null) ? $data->gj_pokok : 0,
            'tj_jabatan' => ($data != null) ? $data->tj_jabatan : 0,
            'tj_teller' => ($data != null) ? $data->tj_teller : 0,
            'tj_perumahan' => ($data != null) ? $data->tj_perumahan : 0,
            'tj_kemahalan' => ($data != null) ? $data->tj_kemahalan : 0,
            'tj_pelaksana' => ($data != null) ? $data->tj_pelaksana : 0,
            'tj_kesejahteraan' => ($data != null) ? $data->tj_kesejahteraan : 0,
            'tj_multilevel' => ($data != null) ? $data->tj_multilevel : 0,
           ];
           array_push($gaji, $gj[$i-1]);
           array_push($total_gaji, array_sum($total_gj[$i-1]));
        // Get Penghasilan tidak teratur karyawan
            for($j = 16; $j <= 21; $j++){
                $penghasilan = DB::table('penghasilan_tidak_teratur')
                    ->where('nip', $nip)
                    ->where('id_tunjangan', $j)
                    ->where('tahun', $tahun)
                    ->where('bulan', $i)
                    ->first();
                $peng[$j-16] = ($penghasilan != null) ? $penghasilan->nominal : 0;
            }
            array_push($ptt, $peng);

            // Get Bonus Karyawan
            for($j = 21; $j <= 24; $j++){
                $bns = DB::table('penghasilan_tidak_teratur')
                    ->where('nip', $nip)
                    ->where('id_tunjangan', $j)
                    ->where('tahun', $tahun)
                    ->where('bulan', $i)
                    ->first();
                $bon[$j-21] = ($bns != null) ? $bns->nominal : 0;
            }
            array_push($bonus, $bon);
        }

        // Get Jamsostek
        foreach($total_gaji as $item){
            array_push($jamsostek, 0.03 * $item);
        }
        // dd($gj);

        return view('penghasilan.gajipajak', [
            'gj' => $gj,
            'jamsostek' => $jamsostek,
            'tunjangan' => $tk,
            'penghasilan' => $ptt,
            'bonus' => $bonus,
            'tahun' => $tahun,
            'karyawan' => $karyawan,
            'request' => $request,
            'mode' => $mode
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('penghasilan.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tj = DB::table('mst_tunjangan')
            ->whereIn('id', [11, 12, 13, 14])
            ->get();
        $tidak_teratur = DB::table('mst_tunjangan')
            ->whereIn('id', [16, 17, 18, 19, 20, 21])
            ->get();
        $bonus = DB::table('mst_tunjangan')
            ->whereIn('id', [22, 23, 24])
            ->get();

        return view('penghasilan.add', [
            'tj' => $tj,
            'tidak_teratur' => $tidak_teratur,
            'bonus' => $bonus
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request);
        $nip = $request->nip;
        try{
            if($request->get('nominal_teratur')[0] != null){
                for($i = 0; $i < count($request->get('nominal_teratur')); $i++){
                    DB::table('tunjangan_karyawan')
                        ->insert([
                            'nip' => $nip,
                            'id_tunjangan' => $request->get('id_teratur')[$i],
                            'nominal' => $request->get('nominal_teratur')[$i],
                            'created_at' => now()
                        ]);
                }
            }
            if($request->get('nominal_tidak_teratur')[0] != null){
                for($i = 0; $i < count($request->get('nominal_tidak_teratur')); $i++){
                    DB::table('penghasilan_tidak_teratur')
                        ->insert([
                            'nip' => $nip,
                            'id_tunjangan' => $request->get('id_tidak_teratur')[$i],
                            'nominal' => $request->get('nominal_tidak_teratur')[$i],
                            'bulan' => $request->get('bulan'),
                            'tahun' => $request->get('bulan'),
                            'created_at' => now()
                        ]);
                }
            }
            if($request->get('nominal_bonus')[0] != null){
                for($i = 0; $i < count($request->get('nominal_bonus')); $i++){
                    DB::table('penghasilan_tidak_teratur')
                        ->insert([
                            'nip' => $nip,
                            'id_tunjangan' => $request->get('id_bonus')[$i],
                            'nominal' => $request->get('nominal_bonus')[$i],
                            'bulan' => $request->get('bulan'),
                            'tahun' => $request->get('bulan'),
                            'created_at' => now()
                        ]);
                }
            }

            Alert::success('Berhasil', 'Berhasil menambahkan data penghasilan');
            return redirect()->route('penghasilan.index');
        } catch(Exception $e){
            DB::rollBack();
            Alert::error('Terjadi Kesalahan', $e->getMessage());
            return redirect()->route('penghasilan.index');
        } catch(QueryException $e){
            DB::rollBack();
            Alert::error('Terjadi Kesalahan', $e->getMessage());
            return redirect()->route('penghasilan.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
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
