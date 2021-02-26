<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TahunSBMPTN;
use App\SebaranProvinsi;
use App\Imports\SebaranProvinsiImport;
use Maatwebsite\Excel\Facades\Excel;
class SebaranProvinsiController extends Controller
{
  public function index(Request $request)
  {
    if(!auth()->user()){
      return redirect('/');
    }
    $p = $request->get('tahun_akademik');
    $data['tahun_akademik'] = TahunSBMPTN::pluck('tahun_akademik', 'kode_tahun_akademik');
    $data['tahun_akademik_pilihan'] = $p;

    $data['sebaran'] = \DB::table('sebaran_provinsi')
                      ->join('tahun_sbmptn', 'sebaran_provinsi.kode_tahun_akademik', '=', 'tahun_sbmptn.kode_tahun_akademik')
                      ->where('sebaran_provinsi.kode_tahun_akademik', $p)
                      ->get();
    return view('sbmptn.sebaran_provinsi', $data);
  }
  public function import(Request $request)
  {
    $d = $request->get('kode_tahun_akademik');
    $request->validate([
      'file' => 'required|mimes:csv,txt,xlsx'
    ]);
    Excel::import(new SebaranProvinsiImport($d), request()->file('file'));
    return redirect()->back()->with('sukses', 'Import Data Sebaran Provinsi PTN Berhasil!');
  }
}
