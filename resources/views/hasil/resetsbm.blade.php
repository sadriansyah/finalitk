@extends('template/master')
@section('sbmptn')
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
              <a href="{{url('/resetsbmptn')}}">
                  <i class="material-icons">swap_calls</i>
                  <span>Reset Data SBMPTN</span>
              </a>
@endsection
@section('content')
<div class="container-fluid">
  <!-- Widgets -->
  <div class="row clearfix">
     <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
          <div class="card">
          <div class="header">
          <div class="block-header">
              <h2>Reset Data Pendaftar SNMPTN</h2>
          </div>
          <!-- Button trigger modal -->

          <div class="card-body">
            @if(session('status'))
            <div class="alert alert-success" role="alert">
                  {{session('status')}}
            </div>
            @endif
          </div>
              </div>
              <div class="body table-responsive">
                <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                  <thead>
                      <tr>
                          <th>No.</th>
                          <th>Tahun Akademik</th>
                          <th>Aksi</th>
                      </tr>
                  </thead>
                  <tbody>
                    @foreach($data_reset as $p)
                      <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$p->tahun_akademik}}</td>
                        <td>
                          <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#konfirmasihapus{{$p->kode_tahun_akademik}}">Reset data</button>
                          <!-- Modal -->
                          <div class="modal fade" id="konfirmasihapus{{$p->kode_tahun_akademik}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                              <div class="modal-dialog" role="document">
                                  <div class="modal-content">
                                      <div class="modal-header">
                                          <h5 class="modal-title" id="exampleModalLabel">Apakah anda yakin ingin mereset data?</h5>
                                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                              <span aria-hidden="true">&times;</span>
                                          </button>
                                      </div>
                                      <form action="{{url('/sbmptnimportreset')}}" method="post">
                                        @csrf
                                      <div class="modal-body">
                                          Mereset data akan mengulang import data SBMPTN dari awal seperti membuat tahun SBMPTN. Apakah anda yakin ?
                                      </div>
                                      <input type="hidden" name="tahun" value="{{$p->kode_tahun_akademik}}">
                                      <div class="modal-footer">
                                          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                          <button type="submit" class="btn btn-primary">Yakin</button>
                                      </div>
                                    </form>

                                  </div>
                              </div>
                          </div>

                        </td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
          </div>
      </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#datatable').DataTable({

        });
    });
</script>
@endpush
