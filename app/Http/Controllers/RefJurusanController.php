<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\RefJurusan;
use App\TahunAkademik;
use App\Imports\RefJurusanImport;
use Maatwebsite\Excel\Facades\Excel;
class RefJurusanController extends Controller
{
  public function index(Request $request)
  {
    if(!auth()->user()){
      return redirect('/');
    }
    $data['listprodi'] = \DB::select("SELECT*FROM prodi");
    $data['tahun'] = \DB::select("SELECT*FROM tahun_akademik order by kode_tahun_akademik ASC");
    $p = $request->get('tahun_akademik');
    $data['tahun_akademik'] = TahunAkademik::pluck('tahun_akademik', 'kode_tahun_akademik');
    $data['tahun_akademik_pilihan'] = $p;
    $data['ref_jurusan'] = \DB::table('ref_jurusan')
                      ->join('tahun_akademik', 'ref_jurusan.kode_tahun_akademik', '=', 'tahun_akademik.kode_tahun_akademik')
                      ->where('ref_jurusan.kode_tahun_akademik', $p)
                      ->get();
    return view('layouts/ref_jurusan', $data);
  }
  public function import(Request $request)
  {
    $d = $request->get('kode_tahun_akademik');
    $request->validate([
        'file' => 'required|mimes:csv,txt'
    ]);
    Excel::import(new RefJurusanImport($d), request()->file('file'));
    return redirect()->back()->with('sukses', 'Import Data Referensi Jurusan Berhasil!');
  }
}
