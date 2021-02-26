<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TahunSBMPTN;
use App\TerimaPTN;
use App\Imports\TerimaPTNImport;
use Maatwebsite\Excel\Facades\Excel;
class TerimaPTNController extends Controller
{
  public function index(Request $request)
  {
    if(!auth()->user()){
      return redirect('/');
    }
    $p = $request->get('tahun_akademik');
    $data['tahun_akademik'] = TahunSBMPTN::pluck('tahun_akademik', 'kode_tahun_akademik');
    $data['tahun_akademik_pilihan'] = $p;

    $data['terima'] = \DB::table('terima_ptn')
                      ->join('tahun_sbmptn', 'terima_ptn.kode_tahun_akademik', '=', 'tahun_sbmptn.kode_tahun_akademik')
                      ->where('terima_ptn.kode_tahun_akademik', $p)
                      ->get();
    return view('sbmptn.terima_ptn', $data);
  }
  public function import(Request $request)
  {
    $d = $request->get('kode_tahun_akademik');
    $request->validate([
        'file' => 'required|mimes:csv,txt,xlsx'
    ]);
    //($request->file);
    Excel::import(new TerimaPTNImport($d), request()->file('file'));
    return redirect()->back()->with('sukses', 'Import Data Terima Per PTN Berhasil!');
  }
}
