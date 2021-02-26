<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TahunSBMPTN;
use App\KeketatanProdi;
use App\KeketatanSaintek;
use App\KeketatanSoshum;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\KeketatanProdiImport;
use App\Imports\KeketatanSoshumImport;
use App\Imports\KeketatanSaintekImport;
class KeketatanController extends Controller
{
  public function prodi(Request $request)
  {
    if(!auth()->user()){
      return redirect('/');
    }
    $p = $request->get('tahun_akademik');
    $data['tahun_akademik'] = TahunSBMPTN::pluck('tahun_akademik', 'kode_tahun_akademik');
    $data['tahun_akademik_pilihan'] = $p;

    $data['ketat'] = \DB::table('keketatan_prodi')
                      ->join('tahun_sbmptn', 'keketatan_prodi.kode_tahun_akademik', '=', 'tahun_sbmptn.kode_tahun_akademik')
                      ->where('keketatan_prodi.kode_tahun_akademik', $p)
                      ->get();
    return view('sbmptn.keketatan_prodi', $data);
  }
  public function importProdi(Request $request)
  {
    if(!auth()->user()){
      return redirect('/');
    }
    $d = $request->get('kode_tahun_akademik');
    $request->validate([
          'file' => 'required|mimes:csv,txt,xlsx'
    ]);
    Excel::import(new KeketatanProdiImport($d), request()->file('file'));
    return redirect()->back()->with('sukses', 'Import Data Keketatan SBMPTN Berhasil!');
  }
  public function saintek(Request $request)
  {
    if(!auth()->user()){
      return redirect('/');
    }
    $p = $request->get('tahun_akademik');
    $data['tahun_akademik'] = TahunSBMPTN::pluck('tahun_akademik', 'kode_tahun_akademik');
    $data['tahun_akademik_pilihan'] = $p;

    $data['ketat'] = \DB::table('keketatan_saintek')
                      ->join('tahun_sbmptn', 'keketatan_saintek.kode_tahun_akademik', '=', 'tahun_sbmptn.kode_tahun_akademik')
                      ->where('keketatan_saintek.kode_tahun_akademik', $p)
                      ->get();
    return view('sbmptn.keketatan_saintek', $data);
  }
  public function importSaintek(Request $request)
  {

    $d = $request->get('kode_tahun_akademik');
    $request->validate([
          'file' => 'required|mimes:csv,txt,xlsx'
    ]);
    Excel::import(new KeketatanSaintekImport($d), request()->file('file'));
    return redirect()->back()->with('sukses', 'Import Data Keketatan SBMPTN Berhasil!');
  }
  public function soshum(Request $request)
  {
    if(!auth()->user()){
      return redirect('/');
    }
    $p = $request->get('tahun_akademik');
    $data['tahun_akademik'] = TahunSBMPTN::pluck('tahun_akademik', 'kode_tahun_akademik');
    $data['tahun_akademik_pilihan'] = $p;

    $data['ketat'] = \DB::table('keketatan_soshum')
                      ->join('tahun_sbmptn', 'keketatan_soshum.kode_tahun_akademik', '=', 'tahun_sbmptn.kode_tahun_akademik')
                      ->where('keketatan_soshum.kode_tahun_akademik', $p)
                      ->get();
    return view('sbmptn.keketatan_soshum', $data);
  }
  public function importSoshum(Request $request)
  {
    $d = $request->get('kode_tahun_akademik');
    $request->validate([
          'file' => 'required|mimes:csv,txt,xlsx'
    ]);
    Excel::import(new KeketatanSoshumImport($d), request()->file('file'));
    return redirect()->back()->with('sukses', 'Import Data Keketatan SBMPTN Berhasil!');
  }
}
