@extends('layouts.main')
@section('isi')
    <div class="card radius-10">
        <div class="card-body">
            @if (session('pesan'))
                <div class="alert border-0 border-start border-5 border-success alert-dismissible fade show py-2">
                    <div class="d-flex align-items-center">
                        <div class="font-35 text-success"><i class='bx bxs-check-circle'></i>
                        </div>
                        <div class="ms-3">
                            <strong>{{ session('pesan') }}</strong>.
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @elseif (session('gagal'))
                <div class="alert border-0 border-start border-5 border-danger alert-dismissible fade show py-2">
                    <div class="d-flex align-items-center">
                        <div class="font-35 text-danger"><i class='bx bxs-message-square-x'></i>
                        </div>
                        <div class="ms-3">
                            <strong>{{ session('hapus') }}</strong>.
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @elseif (count($errors) > 0)
                <div class="alert border-0 border-start border-5 border-danger alert-dismissible fade show py-2">
                    <div class="d-flex align-items-center">
                        <div class="font-35 text-danger"><i class='bx bxs-message-square-x'></i>
                        </div>
                        <div class="ms-3">
                            @foreach ($errors->all() as $error)
                                <h6 class="mb-0 text-danger">Wahh</h6>
                                <div>{{ $error }}</div>
                            @endforeach
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <div class="d-flex align-items-center">
                <div>
                    <h6 class="mb-2">Data Pengguna</h6>
                </div>
                <div class="dropdown ms-auto mb-2">
                    <button type="button" class="btn btn-success" data-bs-toggle="modal"
                        data-bs-target="#modalTambah">Tambah</button>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-striped table-bordered" style="width:100%" id="pengguna-dt">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Nama Lengkap</th>
                            <th>Informasi</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@stop
@section('modal')
    {{-- Modal Tambah --}}
    <div class="modal fade" id="modalTambah" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Cabang</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="card border-top border-0 border-4 border-primary">
                        <div class="card-body p-5">
                            <div class="card-title d-flex align-items-center">
                                <div><i class="lni lni-car-alt me-1 font-22 text-primary"></i>
                                </div>
                                <h5 class="mb-0 text-primary">Tambah Pengguna</h5>
                            </div>
                            <hr>
                            <form class="row g-3" action="/upload/pengguna" method="POST" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                <div class="col-6">
                                    <label for="inputAddress" class="form-label">Nama Lengkap</label>
                                    <input id="email" type="text"
                                        class="form-control @error('nama_kota') is-invalid @enderror" name="name"
                                        value="{{ old('email') }}" required autocomplete="email">

                                    @error('nama_kota')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-3">
                                    <label for="inputAddress" class="form-label">Tanggal Lahir</label>
                                    <input id="email" type="date"
                                        class="form-control @error('nama_kota') is-invalid @enderror" name="tgl_lhr"
                                        value="{{ old('kode_area') }}" required autocomplete="email">

                                    @error('kode_area')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-3">
                                    <label for="inputAddress" class="form-label">Foto</label>
                                    <input id="email" type="file"
                                        class="form-control @error('nama_kota') is-invalid @enderror" name="file_foto"
                                        value="{{ old('kode_area') }}" required autocomplete="email">

                                    @error('kode_area')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-6">
                                    <label for="inputAddress" class="form-label">Email</label>
                                    <input id="email" type="text"
                                        class="form-control @error('nama_kota') is-invalid @enderror" name="email"
                                        value="{{ old('email') }}" required autocomplete="email">

                                    @error('nama_kota')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-6">
                                    <label for="inputAddress" class="form-label">Password</label>
                                    <input id="email" type="password"
                                        class="form-control @error('nama_kota') is-invalid @enderror" name="password"
                                        required autocomplete="email">
                                </div>
                                <div class="col-4">
                                    <label for="inputAddress" class="form-label">Nama Cabang</label>
                                    <select name="id_cabang" id="nama_kota" class="form-select" required>
                                        <option value="">Pilih Cabang .....</option>
                                        @foreach ($cab as $c)
                                            <option value="{{ $c->id_cabang }}">{{ $c->nama_kota }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-4">
                                    <label for="inputAddress" class="form-label">Kode Cabang</label>
                                    <select name="kode_area" id="id_cabang" class="form-control" disabled>

                                    </select>

                                    @error('nama_kota')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-4">
                                    <label for="inputAddress" class="form-label">Jabatan</label>
                                    <select name="id_jabatan" id="nama_kota" class="form-select" required>
                                        <option value="">Pilih Jabatan...</option>
                                        @foreach ($jab as $j)
                                            <option value="{{ $j->id_jabatan }}">{{ $j->nama_jabatan }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-12">
                                    <label for="inputAddress" class="form-label">Alamat</label>
                                    <textarea class="form-control" name="alamat" id="almt_sklh" placeholder="Kata Pengantar..." rows="3"></textarea>
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary ">Simpan</button>
                                    <button type="reset" class="btn btn-danger" data-bs-dismiss="modal">Reset</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    {{-- Modal Hapus --}}
    @foreach ($usr as $c)
        <div class="modal fade" id="modalHapus{{ $c->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Hapus Data</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">Apakah Anda yakin menghapus data?</div>
                    <div class="modal-footer">
                        <a href="/delete_pengguna/{{ $c->id }}" class="btn btn-primary">OK!</a>
                    </div>

                </div>
            </div>
        </div>
    @endforeach
@stop
@section('js')
    <script type="text/javascript">
        let list_pengguna = [];

        $(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('#nama_kota').on('change', function() {
                $.ajax({
                    url: '{{ url('kodearea') }}',
                    method: 'POST',
                    data: {
                        id_cabang: $(this).val()
                    },
                    success: function(response) {
                        $('#id_cabang').empty();

                        $.each(response, function(id_cabang, kode_area) {
                            // console.log(kode_area)
                            $('#id_cabang').append(new Option(kode_area, kode_area))
                        })
                    }
                })
            });
        });

        const table = $("#pengguna-dt").DataTable({
            "pageLength": 10,
            "lengthMenu": [
                [10, 25, 50, 100],
                [10, 25, 50, 100]
            ],
            "bLengthChange": true,
            "bFilter": true,
            "bInfo": true,
            "processing": true,
            "bServerSide": true,
            "order": [
                [1, "asc"]
            ],
            "ajax": {
                url: "{{ url('list_pengguna') }}",
                type: "POST",
                data: function(d) {
                    d._token = "{{ csrf_token() }}"
                }
            },
            "columnDefs": [{
                "targets": 0,
                "data": "id",
                "render": function(data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                }
            }, {
                "targets": 1,
                "data": "name",
                "render": function(data, type, row, meta) {
                    list_pengguna[row.id] = row;
                    return `<p><b>` + data + `</b><br>` +
                        row.email + `</p>`;
                    // console.log(list_pengguna);
                }
            }, {
                "targets": 2,
                "data": "id",
                "render": function(data, type, row, meta) {
                    return `<p><b>Jabatan: </b>` + row.nama_jabatan + `<br>` +
                        `<b>` + row.nama_kota + `</b> -- ` + row.kode_area + `<br>` +
                        `<b>Alamat: </b>` + row.alamat + `</p>`;
                    // return data;
                }
            }, {
                "targets": 3,
                "sortable": false,
                "data": "email",
                "render": function(data, type, row, meta) {
                    var tampilan = ``;
                    // var ucwords($kalimat);
                    if (data == 'admin@mail.com') {
                        tampilan +=
                            ``
                    } else {
                        tampilan +=
                            `<div class="d-flex order-actions">
                            <a href="javascript:;" class="ms-3" data-bs-toggle="modal" data-bs-target="#modalEdit${row.id}"><i class='bx bxs-edit'></i></a>
						    <a href="javascript:;" class="ms-3" data-bs-toggle="modal" data-bs-target="#modalHapus${row.id}"><i class='bx bxs-trash'></i></a>
                        </div>`
                    }
                    return tampilan;
                }
                //  <a data-bs-toggle="modal" data-bs-target="#modalDetail"><i class='lni lni-eye'></i></a>
            }, ]
        });
    </script>
@stop
