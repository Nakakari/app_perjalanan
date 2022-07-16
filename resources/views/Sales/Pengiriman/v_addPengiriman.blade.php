@extends('layouts.main')

@section('isi')
    @if ($id_cabang == Auth::user()->id_cabang)
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Sales / Counter</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="/sales/home"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item"><a href="/pengiriman/{{ Auth::user()->id_cabang }}"><i
                                    class="bx bx-cart"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Tambah Pengiriman</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!--end breadcrumb-->
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
                <div class="card border-top border-0 border-4 border-primary">
                    <div class="card-body p-5">
                        <div class="card-title d-flex align-items-center">
                            <h5 class="mb-0 text-primary">Detail Surat Jalan</h5>
                        </div>
                        <hr>
                        <form id="form-addPengiriman" class="row g-3" action="/upload/pengiriman/{{ $id_cabang }}"
                            method="POST" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="col-6">
                                <label for="inputAddress" class="form-label">Np. Tracking / No. Resi</label>
                                <input id="no_resi" type="text" class="form-control" name="no_resi"
                                    value="{{ $nomor }}" readonly>
                                <input id="dari_cabang" type="hidden" class="form-control" name="dari_cabang"
                                    value="{{ $id_cabang }}">
                                <input id="status_sent" type="hidden" class="form-control" name="status_sent"
                                    value="{{ $status_sent }}">

                                @error('no_resi')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-6">
                                <label for="inputAddress" class="form-label">Np. Tracking / No. Resi Manual
                                    (Opsional)</label>
                                <input id="no_resi_manual" type="text" class="form-control" name="no_resi_manual">
                            </div>
                            <div class="col-6">
                                <label for="inputAddress" class="form-label">Warehouse Tujuan</label>
                                <select name="id_cabang_tujuan" id="id_cabang_tujuan" class="form-select" required>
                                    <option value="" selected>--- Pilih Cabang Tujuan ---</option>
                                    @foreach ($cab as $c)
                                        {{-- @if ($c->id_cabang == Auth::user()->id_cabang) --}}
                                        <option value="{{ $c->id_cabang }}">
                                            {{ $c->nama_kota }}</option>
                                        {{-- @endif --}}
                                    @endforeach
                                </select>
                                {{-- @endforeach --}}
                            </div>
                            <div class="col-6">
                                <label for="inputAddress" class="form-label">Tanggal</label>
                                <input id="tgl_masuk" type="text" class="form-control" name="tgl_masuk"
                                    value="{{ $today }}" readonly>
                            </div>
                            <hr>
                            <div class="card-title d-flex align-items-center">
                                <h5 class="col-6 mb-0 text-primary">Detail Pengirim</h5>
                                <h5 class="col-6 mb-0 text-primary">Detail Penerima</h5>
                            </div>
                            <hr>
                            <div class="col-6">
                                <label for="inputAddress" class="form-label">Nama Pengirim</label>
                                <input id="nama_pengirim" type="text"
                                    class="form-control @error('nama_pengirim') is-invalid @enderror" name="nama_pengirim"
                                    required autocomplete="email">
                                {{-- <select name="id_pelanggan" id="nama_perusahaan" class="form-select" required>
                                    <option value="">Pilih Pengirim .....</option>
                                    @foreach ($plgn as $plg)
                                        <option value="{{ $plg->id_pelanggan }}">{{ $plg->nama_perusahaan }}</option>
                                    @endforeach
                                </select> --}}
                            </div>
                            <div class="col-6">
                                <label for="inputAddress" class="form-label">Nama Penerima</label>
                                <input id="id_penerima" type="text"
                                    class="form-control @error('nama_kota') is-invalid @enderror" name="nama_penerima"
                                    required autocomplete="email">
                            </div>
                            <div class="col-6">
                                <label for="inputAddress" class="form-label">Kota Pengirim</label>
                                @foreach ($cab as $ca)
                                    @if (Auth::user()->id_cabang == $ca->id_cabang)
                                        <input id="kota_pengirim" type="text"
                                            class="form-control @error('nama_pengirim') is-invalid @enderror"
                                            name="kota_pengirim" value="{{ $ca->nama_kota }}" readonly>
                                    @endif
                                @endforeach
                            </div>
                            <div class="col-6">
                                <label for="inputAddress" class="form-label">Kota Penerima</label>
                                <input id="kota_penerima" type="text"
                                    class="form-control @error('kota_penerima') is-invalid @enderror" name="kota_penerima"
                                    required autocomplete="email">
                            </div>
                            <div class="col-6">
                                <label for="inputAddress" class="form-label">Alamat Pengirim</label>
                                <textarea class="form-control" name="alamat_pengirim" id="alamat_pengirim" placeholder="Alamat Pengirim..."
                                    rows="3"></textarea>
                            </div>
                            <div class="col-6">
                                <label for="inputAddress" class="form-label">Alamat Penerima</label>
                                <textarea class="form-control" name="alamat_penerima" id="alamat_penerima" placeholder="Alamat Penerima..."
                                    rows="3"></textarea>
                            </div>
                            <div class="col-6">
                                <label for="inputAddress" class="form-label">No. Telephone</label>
                                <input id="tlp_pengirim" type="text"
                                    class="form-control @error('tlp_pengirim') is-invalid @enderror" name="tlp_pengirim"
                                    value="{{ old('tlp_pengirim') }}" required>

                                @error('tlp_pengirim')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-6">
                                <label for="inputAddress" class="form-label">No. Telephone</label>
                                <input id="email" type="text"
                                    class="form-control @error('no_penerima') is-invalid @enderror" name="no_penerima"
                                    required>
                                @error('no_penerima')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <hr>
                            <div class="card-title d-flex align-items-center">
                                <h5 class="col-6 mb-0 text-primary">Detail Barang</h5>

                            </div>
                            <hr>
                            <div class="col-6">
                                <label for="inputAddress" class="form-label">Isi Barang</label>
                                <input id="email" type="text" class="form-control" name="isi_barang" required>
                            </div>
                            <div class="col-6">
                                <label for="inputAddress" class="form-label">Jumlah Koli</label>
                                <input id="email" type="number"
                                    class="form-control @error('nama_kota') is-invalid @enderror" name="koli" required
                                    autocomplete="email">
                            </div>
                            <div class="col-6">
                                <label for="inputAddress" class="form-label">Asli</label>
                                <div class="input-group">
                                    <input id="berat_kg" type="number" class="form-control" name="berat_kg"><span
                                        class="input-group-text">Kg</span>
                                </div>
                            </div>
                            <div class="col-6">
                                <label for="inputAddress" class="form-label">Volume (Opsional)</label>
                                <div class="input-group">
                                    <input id="berat_m" type="text"
                                        class="form-control @error('nama_kota') is-invalid @enderror" name="berat_m"><span
                                        class="input-group-text">M3</span>
                                </div>
                            </div>
                            <hr>
                            <div class="card-title d-flex align-items-center">
                                <h5 class="col-6 mb-0 text-primary">Detail Pengiriman</h5>
                            </div>
                            <hr>
                            <div class="col-6">
                                <label for="inputAddress" class="form-label">Pelayanan</label>
                                <select name="no_pelayanan" id="no_pelayanan" class="form-select" required>
                                    <option value="">Pilih Jenis Pelayanan .....</option>
                                    @foreach ($plyn as $ply)
                                        <option value="{{ $ply->id_pelayanan }}">{{ $ply->nama_pelayanan }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-6">
                                <label for="inputAddress" class="form-label">Moda</label>
                                <select name="no_moda" id="no_moda" class="form-select" required>
                                    <option value="">Pilih Moda .....</option>
                                    @foreach ($moda as $md)
                                        <option value="{{ $md->id_moda }}">{{ $md->nama_moda }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <hr>
                            <div class="card-title d-flex align-items-center">
                                <div><i class="lni lni-car-alt me-1 font-22 text-primary"></i>
                                </div>
                                <h5 class="col-6 mb-0 text-primary">Detail Pembayaran</h5>
                            </div>
                            <hr>
                            <div class="col-6">
                                <label for="inputAddress" class="form-label">Biaya</label>
                                <div class="input-group flex-nowrap">
                                    <span class="input-group-text" id="addon-wrapping">Rp</span><input id="biaya"
                                        type="text" class="form-control @error('nama_kota') is-invalid @enderror"
                                        name="biaya" required autocomplete="email">
                                </div>
                            </div>
                            <div class="col-6">
                                <label for="inputAddress" class="form-label">Pembayaran</label>
                                <select name="tipe_pembayaran" id="tipe_pembayaran" class="form-select" required>
                                    <option value="">Pilih Pembayaran .....</option>
                                    @foreach ($pembayaran as $pb)
                                        <option value="{{ $pb->id_pembayaran }}">{{ $pb->nama_tipe_pemb }}</option>
                                    @endforeach
                                </select>
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
    @else
        <p>Whoops!</p>
    @endif
@stop
@section('js')
    <script type="text/javascript">
        const textarea = document.getElementById('id_pelanggan');

        $(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('#nama_kota').on('change', function() {
                $.ajax({
                    url: '{{ url('kodeareapengguna') }}',
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

        $(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('#nama_perusahaan').on('change', function() {
                $.ajax({
                    url: '{{ url('kodepelanggan') }}',
                    method: 'POST',
                    data: {
                        id_pelanggan: $(this).val()
                    },
                    success: function(response) {
                        $('#id_pelanggan').empty();
                        $("#form-addPengiriman textarea").val('')
                        $("#form-addPengiriman [name='tlp_spv']").val('')

                        $.each(response, function(tlp_spv, alamat_penerima) {
                            console.log(tlp_spv)
                            // $('#id_pelanggan').append(new Option(alamat_penerima,
                            //     alamat_penerima))

                            textarea.value = alamat_penerima;
                            $("#form-addPengiriman [name='tlp_spv']").val(tlp_spv)
                        })
                    }
                })
            });
        });
    </script>
@stop
