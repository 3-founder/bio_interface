<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class KantorCabangController extends Controller
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
        $data = DB::table('mst_cabang')
            ->get();

        return view('cabang.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('cabang.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'kode_cabang' => 'required',
            'nama_cabang' => 'required',
            'alamat_cabang' => 'required'
        ], [
            'required' => 'Data harus diisi.'
        ]);

        try{
            DB::table('mst_cabang')
                ->insert([
                    'kd_cabang' => $request->get('kode_cabang'),
                    'nama_cabang' => $request->get('nama_cabang'),
                    'alamat_cabang' => $request->get('alamat_cabang'),
                    'id_kantor' => 2,
                    'created_at' => now()
                ]);

            Alert::success('Berhasil', 'Berhasil Menambah Kantor Cabang.');
            return redirect()->route('cabang.index');
        } catch(Exception $e){
            Alert::error('Terjadi Kesalahan', 'Kode Cabang Telah Digunakan.');
            return redirect()->route('cabang.index')->withStatus($e->getMessage());
        } catch(QueryException $e){
            Alert::error('Terjadi Kesalahan', 'Gagal Menambah Kantor Cabang.');
            return redirect()->route('cabang.index')->withStatus($e->getMessage());
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
        $data = DB::table('mst_cabang')
            ->where('kd_cabang', $id)
            ->first();

        return view('cabang.edit', ['data' => $data]);
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
        $request->validate([
            'kode_cabang' => 'required',
            'nama_cabang' => 'required',
            'alamat_cabang' => 'required'
        ], [
            'required' => 'Data harus diisi.'
        ]);

        try{
            DB::table('mst_cabang')
                ->where('kd_cabang', $id)
                ->update([
                    'nama_cabang' => $request->get('nama_cabang'),
                    'alamat_cabang' => $request->get('alamat_cabang'),
                    'id_kantor' => 2,
                    'updated_at' => now()
                ]);

            Alert::success('Berhasil', 'Berhasil Mengupdate Kantor Cabang.');
            return redirect()->route('cabang.index');
        } catch(Exception $e){
            Alert::error('Terjadi Kesalahan', 'Kode Cabang Telah Digunakan.');
            return redirect()->route('cabang.index')->withStatus($e->getMessage());
        } catch(QueryException $e){
            Alert::error('Terjadi Kesalahan', 'Gagal Mengupdate Kantor Cabang');
            return redirect()->route('cabang.index')->withStatus($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            DB::table('mst_cabang')
                ->where('kd_cabang', $id)
                ->delete();

            Alert::success('Berhasil', 'Berhasil Menghapus Kantor Cabang.');
            return redirect()->route('cabang.index');
        } catch(Exception $e){
            Alert::error('Terjadi Kesalahan', ''.$e);
            return redirect()->route('cabang.index')->withStatus($e->getMessage());
        } catch(QueryException $e){
            Alert::error('Terjadi Kesalahan', ''.$e);
            return redirect()->route('cabang.index')->withStatus($e->getMessage());
        }
    }
}
