<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TahunSBMPTN;
use App\NilaiSaintek;
use App\NilaiSoshum;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\NilaiSaintekImport;
use App\Imports\NilaiSoshumImport;

class TerimaNilaiPTNController extends Controller
{
  public function saintek(Request $request)
  {
    if(!auth()->user()){
      return redirect('/');
    }
    $p = $request->get('tahun_akademik');
    $data['tahun_akademik'] = TahunSBMPTN::pluck('tahun_akademik', 'kode_tahun_akademik');
    $data['tahun_akademik_pilihan'] = $p;

    $data['nilai'] = \DB::table('terima_saintek')
                      ->join('tahun_sbmptn', 'terima_saintek.kode_tahun_akademik', '=', 'tahun_sbmptn.kode_tahun_akademik')
                      ->where('terima_saintek.kode_tahun_akademik', $p)
                      ->get();
    return view('sbmptn.nilai_saintek', $data);
  }
  public function importSaintek(Request $request)
  {
    $d = $request->get('kode_tahun_akademik');
    $request->validate([
        'file' => 'required|mimes:csv,txt,xlsx'
    ]);
    Excel::import(new NilaiSaintekImport($d), request()->file('file'));
    return redirect()->back()->with('sukses', 'Import Data Terima Per PTN Berhasil!');
  }
  public function soshum(Request $request)
  {
    if(!auth()->user()){
      return redirect('/');
    }
    $p = $request->get('tahun_akademik');
    $data['tahun_akademik'] = TahunSBMPTN::pluck('tahun_akademik', 'kode_tahun_akademik');
    $data['tahun_akademik_pilihan'] = $p;

    $data['nilai'] = \DB::table('terima_soshum')
                      ->join('tahun_sbmptn', 'terima_soshum.kode_tahun_akademik', '=', 'tahun_sbmptn.kode_tahun_akademik')
                      ->where('terima_soshum.kode_tahun_akademik', $p)
                      ->get();
    return view('sbmptn.nilai_soshum', $data);
  }
  public function importSoshum(Request $request)
  {
    $d = $request->get('kode_tahun_akademik');
    $request->validate([
        'file' => 'required|mimes:csv,txt,xlsx'
    ]);
    Excel::import(new NilaiSoshumImport($d), request()->file('file'));
    return redirect()->back()->with('sukses', 'Import Data Terima Per PTN Berhasil!');
  }
}
