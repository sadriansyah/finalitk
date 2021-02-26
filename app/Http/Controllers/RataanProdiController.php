<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TahunSBMPTN;
use App\RataanProdi;
use App\Imports\RataanProdiImport;
use Maatwebsite\Excel\Facades\Excel;
class RataanProdiController extends Controller
{
  public function index(Request $request)
  {
    if(!auth()->user()){
      return redirect('/');
    }
    $p = $request->get('tahun_akademik');
    $data['tahun_akademik'] = TahunSBMPTN::pluck('tahun_akademik', 'kode_tahun_akademik');
    $data['tahun_akademik_pilihan'] = $p;

    $data['rataan'] = \DB::table('rataan_prodi')
                      ->join('tahun_sbmptn', 'rataan_prodi.kode_tahun_akademik', '=', 'tahun_sbmptn.kode_tahun_akademik')
                      ->where('rataan_prodi.kode_tahun_akademik', $p)
                      ->get();
    return view('sbmptn.rataan_prodi', $data);
  }
  public function import(Request $request)
  {
    $d = $request->get('kode_tahun_akademik');
    $request->validate([
        'file' => 'required'
    ]);
    //$a = ExceL::import(new RataanProdiImport($d), request()->file('file'));

    // menangkap file excel
	$file = $request->file('file');

	// membuat nama file unik
	$nama_file = rand().$file->getClientOriginalName();

	// upload ke folder file_siswa di dalam folder public
	$file->move('file_sbmptn',$nama_file);

	// import data
	Excel::import(new RataanProdiImport($d), public_path('/file_sbmptn/'.$nama_file));
  return redirect()->back()->with('sukses', 'Import Data Rataan Per Prodi Berhasil!');
  }
}
