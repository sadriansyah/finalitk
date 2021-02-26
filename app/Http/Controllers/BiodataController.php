<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TahunSBMPTN;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\BiodataTerimaImport;
use App\Imports\BiodataTerimabidikmisiImport;
use App\Imports\BiodataPeminatImport;
class BiodataController extends Controller
{
  public function index(Request $request)
  {
    if(!auth()->user()){
      return redirect('/');
    }
    $p = $request->get('tahun_akademik');
    $data['tahun_akademik'] = TahunSBMPTN::pluck('tahun_akademik', 'kode_tahun_akademik');
    $data['tahun_akademik_pilihan'] = $p;
    $data['biodata'] = \DB::table('biodata_terima')
                      ->join('tahun_akademik', 'biodata_terima.kode_tahun_akademik', '=', 'tahun_akademik.kode_tahun_akademik')
                      ->where('biodata_terima.kode_tahun_akademik', $p)
                      ->get();
    return view('sbmptn/biodata_terima', $data);
  }
  public function import(Request $request)
  {
    if(!auth()->user()){
      return redirect('/');
    }
    $d = $request->get('kode_tahun_akademik');
    $request->validate([
        'file' => 'required|mimes:csv,txt,xlsx'
    ]);
    Excel::import(new BiodataTerimaImport($d), request()->file('file'));
    return redirect()->back()->with('sukses', 'Import Data Biodata Penerima Berhasil!');
  }
  public function index1(Request $request)
  {
    $p = $request->get('tahun_akademik');
    $data['tahun_akademik'] = TahunSBMPTN::pluck('tahun_akademik', 'kode_tahun_akademik');
    $data['tahun_akademik_pilihan'] = $p;
    $data['biodata'] = \DB::table('biodata_terima_bidikmisi')
                      ->join('tahun_akademik', 'biodata_terima_bidikmisi.kode_tahun_akademik', '=', 'tahun_akademik.kode_tahun_akademik')
                      ->where('biodata_terima_bidikmisi.kode_tahun_akademik', $p)
                      ->get();
    return view('sbmptn/biodata_terima_bidikmisi', $data);
  }
  public function import1(Request $request)
  {
    if(!auth()->user()){
      return redirect('/');
    }
    $d = $request->get('kode_tahun_akademik');
    $request->validate([
        'file' => 'required|mimes:csv,txt,xlsx'
    ]);
    Excel::import(new BiodataTerimabidikmisiImport($d), request()->file('file'));
    return redirect()->back()->with('sukses', 'Import Data Biodata Penerima Bidikmisi Berhasil!');
  }
  public function index2(Request $request)
  {
    if(!auth()->user()){
      return redirect('/');
    }
    $p = $request->get('tahun_akademik');
    $data['tahun_akademik'] = TahunSBMPTN::pluck('tahun_akademik', 'kode_tahun_akademik');
    $data['tahun_akademik_pilihan'] = $p;
    $data['biodata'] = \DB::table('biodata_peminat')
                      ->join('tahun_akademik', 'biodata_peminat.kode_tahun_akademik', '=', 'tahun_akademik.kode_tahun_akademik')
                      ->where('biodata_peminat.kode_tahun_akademik', $p)
                      ->get();
    return view('sbmptn/biodata_peminat', $data);
  }
  public function import2(Request $request)
  {
    $d = $request->get('kode_tahun_akademik');
    $request->validate([
        'file' => 'required|mimes:csv,txt,xlsx'
    ]);
    Excel::import(new BiodataPeminatImport($d), request()->file('file'));
    return redirect()->back()->with('sukses', 'Import Data Biodata Peminat Berhasil!');
  }
}
