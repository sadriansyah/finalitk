<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\TahunAkademik;
use App\DataSiswa;
use Illuminate\Support\Facades\DB;
use App\Exports\CsvExport;
use App\Imports\UsersImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Hash;
use ZanySoft\Zip\Zip;
class DashboardController extends Controller
{
    public function beranda()
    {
      if(!auth()->user()){
        return redirect('/');
      }
      $prodi = DB::select("SELECT*FROM prodi");
      $tahun = DB::select("SELECT*FROM tahun_akademik order by kode_tahun_akademik ASC");
    	return view('template/dashboard',['listprodi' => $prodi, 'tahun' => $tahun]);
    }

    public function addedfileprestasi(Request $req){

      $tahun = $req->kode_tahun_akademik;
      $files = $req->file('file');
      $namafile = "".$files->getClientOriginalName();
      $upload = 'DokumenPendaftaran';
      $files->move($upload,$namafile);
      $path = $upload."/".$namafile;
      $zip = Zip::open($path);
      $zip->extract(public_path()."/".$upload."/".$tahun);
      unlink($path);
      //

       return response()->json(['success' => 'File Telah diupload']);

    }

    public function fileprestasi(){
      if(!auth()->user()){
        return redirect('/');
      }
      $data['listprodi'] = \DB::select("SELECT*FROM prodi");
      $data['tahun'] = \DB::select("SELECT*FROM tahun_akademik order by kode_tahun_akademik ASC");
      $p="";
      $data['tahun_akademik'] = TahunAkademik::pluck('tahun_akademik', 'kode_tahun_akademik');
      $data['tahun_akademik_pilihan'] = $p;
      $data['jurusan'] = \DB::table('data_jurusan')
                        ->join('tahun_akademik', 'data_jurusan.kode_tahun_akademik', '=', 'tahun_akademik.kode_tahun_akademik')
                        ->where('data_jurusan.kode_tahun_akademik', $p)
                        ->get();
      return view('hasil.zipupload',$data);
    }

    public function testcsv()
    {
    	$data = User::all();
    	return view('template/testcsv', compact('data'));
    }
    public function csv_export()
    {
    	return Excel::download(new CsvExport, 'sample.xlsx');
    }
    public function csv_import()
    {
    	Excel::import(new UsersImport, request()->file('file'));
    	return back();
    }
    public function siswaBidikmisi()
    {
      if(!auth()->user()){
        return redirect('/');
      }
        return view('siswa/bidikmisi');
    }
    public function akun()
    {
      if(!auth()->user()){
        return redirect('/');
      }
      $data['listprodi'] = DB::select("SELECT*FROM prodi");
      $data['tahun'] = DB::select("SELECT*FROM tahun_akademik order by kode_tahun_akademik ASC");
      $data['user'] = User::all();
      return view('akun/index',$data);
    }
    public function store(Request $request)
    {
      if(!auth()->user()){
        return redirect('/');
      }
      $request->validate([
          'username' => 'required|unique:users|min:5',
          'nama' => 'required|min:5',
          'password' => 'required|min:5',
      ]);

      $akun = New User();
      $akun->username = $request->username;
      $akun->nama = $request->nama;
      $akun->role = $request->role;
      $akun->password = Hash::make($request->password);
      $akun->save();
      return redirect()->back()->with('status', 'Data User Berhasil Ditambahkan');
    }
    public function destroy($id)
    {
      if(!auth()->user()){
        return redirect('/');
      }
      $akun = User::where('id', $id);
      $akun->delete();
      return redirect()->back()->with('status', 'Data User Berhasil Dihapus');
    }
    public function ganti_password($id)
    {
      if(!auth()->user()){
        return redirect('/');
      }

      //dd($a);
      $data['user'] = User::where('id',$id)->get();

      return view('akun.ganti_password',$data);
    }
    public function postGantiPassword(Request $request,$id)
    {
      if(!auth()->user()){
        return redirect('/');
      }
      $request->validate([
          'nama' => 'required|min:5',
      ]);
      $user = User::where('id', $id)->first();
      $user->nama = $request->nama;
      if($request->password!="")
      {
        $user->password = Hash::make($request->password);
      }
      $user->update();
      return redirect()->back()->with('status', 'Data User Berhasil Update');
    }
}
