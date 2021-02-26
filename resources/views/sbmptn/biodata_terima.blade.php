@extends('template/master')
@section('sbmptn')
<li>
  <a href="javascript:void(0);" class="menu-toggle">
      <i class="material-icons">swap_calls</i>
      <span>Master Data SBMPTN</span>
  </a>
  <ul class="ml-menu">
<li>
  <a href="{{url('/tahun_sbmptn')}}">
      <i class="material-icons">text_fields</i>
      <span>Tahun SBMPTN</span>
  </a>
</li>

  </ul>
</li>
<li>
                    <a href="javascript:void(0);" class="menu-toggle">
                        <i class="material-icons">swap_calls</i>
                        <span>SBMPTN</span>
                    </a>
                    <ul class="ml-menu">
                  <li>
                    <a href="{{url('/terima_ptn')}}">
                        <i class="material-icons">text_fields</i>
                        <span>Terima Per PTN</span>
                    </a>
                </li>
                <li>
                  <a href="{{url('/sebaran_provinsi')}}">
                      <i class="material-icons">text_fields</i>
                      <span>Sebaran Provinsi</span>
                  </a>
              </li>
              <li>
                <a href="{{url('/rataan_prodi')}}">
                    <i class="material-icons">text_fields</i>
                    <span>Rataan Per Prodi</span>
                </a>
            </li>

            <li>
                <a href="javascript:void(0);" class="menu-toggle">
                    <span>PTN Nilai Terima</span>
                </a>
                <ul class="ml-menu">
                    <li>
                        <a href="{{url('/terima_saintek')}}">
                            <span>SAINTEK</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{url('/terima_soshum')}}">
                            <span>SOSHUM</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li>
                  <a href="javascript:void(0);" class="menu-toggle">
                      <span>Biodata</span>
                  </a>
                  <ul class="ml-menu">
                      <li>
                          <a href="{{url('/biodata_terima')}}">
                              <span>Biodata Terima</span>
                          </a>
                      </li>
                      <li>
                          <a href="{{url('/biodata_bidikmisi')}}">
                              <span>Biodata Bidikmisi</span>
                          </a>
                      </li>
                      <li>
                          <a href="{{url('/biodata_peminat')}}">
                              <span>Biodata Peminat</span>
                          </a>
                      </li>
                  </ul>
                </li>

              <li>
                  <a href="javascript:void(0);" class="menu-toggle">
                      <span>Keketatan</span>
                  </a>
                  <ul class="ml-menu">
                      <li>
                          <a href="{{url('/keketatan_prodi')}}">
                              <span>PRODI</span>
                          </a>
                      </li>
                      <li>
                          <a href="{{url('/keketatan_saintek')}}">
                              <span>SAINTEK</span>
                          </a>
                      </li>
                      <li>
                          <a href="{{url('/keketatan_soshum')}}">
                              <span>SOSHUM</span>
                          </a>
                      </li>
                  </ul>
                </li>
              </ul>
              </li>

@endsection
@section('content')
<div class="container-fluid">

            <!-- Widgets -->
            <div class="row clearfix">
               <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                    <div class="header">
                    <div class="block-header">
                        <h2>Data Biodata Penerima</h2>
                    </div>
                    <form action="{{url('/biodata_terima')}}" method="get">
                      @csrf
                    <table class="table table-bordered table-striped table-hover">
                      <tr>
                        <td>Tahun Akademik</td>
                        <td>{{ Form::select('tahun_akademik',$tahun_akademik,$tahun_akademik_pilihan,['class' => 'form-control show-tick']) }}</td>
                        <tr>
                      <tr>
                        <td></td>
                        <td>
                          <button type="submit" class="btn btn-primary">Tampilkan</button>
                          <!-- Button trigger modal -->
                        </td>
                      </tr>
                    </table>
                    </form>
                        <!-- Button trigger modal -->
                                <button type="button" class="btn btn-success float-right mt-2 mb-2" data-toggle="modal" data-target="#exampleModal4">
                                    Import Data
                                </button>
                                <div class="card-body">
                                  @if(session('sukses'))
                                  <div class="alert alert-success" role="alert">
                                        {{session('sukses')}}
                                  </div>
                                  @endif
                                </div>
                        </div>
                        <div class="body table-responsive">
                            <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                <thead>
                                    <tr>
                                        <td rowspan="2">No.</td>
                                        <td rowspan="2" class="text-center">Kode Peserta</td>
                                        <td rowspan="2" class="text-center">Nama Peserta</td>
                                        <td colspan="3" class="text-center">Prodi Terima</td>
                                        <td colspan="4" class="text-center">Ayah</td>
                                        <td colspan="4" class="text-center">Ibu</td>
                                        <td rowspan="2" class="text-center">Pil 1</td>
                                        <td rowspan="2" class="text-center">Pil 2</td>
                                        <td rowspan="2" class="text-center">Tpt Lahir</td>
                                        <td rowspan="2" class="text-center">Tgl Lahir</td>
                                        <td colspan="5" class="text-center">SLTA</td>
                                    </tr>
                                    <tr>
                                        <td>Kode</td>
                                        <td>Nama</td>
                                        <td>Pil</td>
                                        <td>Nama</td>
                                        <td>Pendidikan</td>
                                        <td>Pekerjaan</td>
                                        <td>Penghasilan</td>
                                        <td>Nama</td>
                                        <td>Pendidikan</td>
                                        <td>Pekerjaan</td>
                                        <td>Penghasilan</td>
                                        <td>Kode</td>
                                        <td>Nama</td>
                                        <td>Kab</td>
                                        <td>Prov</td>
                                        <td>Thn Lulus</td>
                                    </tr>
                                </thead>
                                <tbody>
                                  @foreach($biodata as $p)
                                    <tr>
                                      <td>{{$loop->iteration}}</td>
                                      <td>{{$p->kode_peserta}}</td>
                                      <td>{{$p->nama_peserta}}</td>
                                      <td>{{$p->kode_prodi_terima}}</td>
                                      <td>{{$p->nama_prodi_terima}}</td>
                                      <td>{{$p->pil_prodi_terima}}</td>
                                      <td>{{$p->nama_ayah}}</td>
                                      <td>{{$p->pendidikan_ayah}}</td>
                                      <td>{{$p->pekerjaan_ayah}}</td>
                                      <td>{{$p->penghasilan_ayah}}</td>
                                      <td>{{$p->nama_ibu}}</td>
                                      <td>{{$p->pendidikan_ibu}}</td>
                                      <td>{{$p->pekerjaan_ibu}}</td>
                                      <td>{{$p->penghasilan_ibu}}</td>
                                      <td>{{$p->pil1}}</td>
                                      <td>{{$p->pil2}}</td>
                                      <td>{{$p->tempat_lahir}}</td>
                                      <td>{{$p->tgl_lahir}}</td>
                                      <td>{{$p->kode_slta}}</td>
                                      <td>{{$p->nama_slta}}</td>
                                      <td>{{$p->kabupaten}}</td>
                                      <td>{{$p->provinsi}}</td>
                                      <td>{{$p->tahun_lulus}}</td>
                                    </tr>
                                  @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- #END# Widgets -->

</div>
@endsection
<!-- Modal -->
<div class="modal fade" id="exampleModal4" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel5" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel5">
                  <div class="custom-title-wrap bar-warning">
                      <div class="custom-title">Form Import Data Penerima</div>
                  </div>
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="modal-body">
              <form action="{{url('/importBiodataTerima')}}" method="post" enctype="multipart/form-data">
                  @csrf
              <div class="form-group">
                  <label for="recipient-name" class="col-form-label">Tahun</label>
                {{Form::select('kode_tahun_akademik',$tahun_akademik,null,['class' => 'form-control show-tick']) }}
              </div>
              <div class="form-group">
                  <label for="message-text" class="col-form-label">Import File (.csv)</label>
                  <input type="file" class="form-control" name="file" required>
                  <a href="{{asset('master_sbmptn/Template Biodata Terima SBMPTN.xlsx')}}">
                    Download Template SBMPTN Biodata Terima (Khusus SBMPTN harap mengikuti format yang telah disediakan)
                  </a>
              </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                {{Form::submit('Simpan Data',['class' => 'btn btn-primary']) }}
            </div>
            </form>
        </div>
    </div>
</div>
