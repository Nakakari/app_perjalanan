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
                        <li class="breadcrumb-item active" aria-current="page">Pengiriman</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!--end breadcrumb-->
        <div class="row row-cols-1 row-cols-md-2 row-cols-xl-3">
            <div class="col">
                <div class="card radius-10">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div>
                                <p class="mb-0 text-secondary">Total Omset</p>
                                {{-- <h4 class="my-1">Rp{{ number_format($totalOmset->jumlah, 2, ',', '.') }}</h4> --}}
                                <h4 id="omsetheading" class="my-1 omsetheading">
                                    Rp{{ number_format($totalOmset->jumlah, 2, ',', '.') }}</h4>
                                <h4 id="omsetheading2" class="my-1 omsetheading2">
                                </h4>
                                <p id="p_omset" class="mb-0 font-13 text-success p_omset"><strong>Default</strong></p>
                                <p id="p_omset2" class="mb-0 font-13 text-success p_omset2"><strong></strong></p>
                            </div>
                            <div class="widgets-icons bg-light-success text-success ms-auto"><i class="bx bxs-wallet"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card radius-10">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div>
                                <p class="mb-0 text-secondary">Transaksi</p>
                                <h4 id="transaksi" class="my-1">{{ $totalTransaksi }}</h4>
                                <p class="mb-0 font-13 text-danger"><strong>Resi</strong></p>
                            </div>
                            <div class="widgets-icons bg-light-info text-info ms-auto"><i class='bx bx-user-pin'></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card radius-10">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div>
                                <p class="mb-0 text-secondary">Tonase</p>
                                <h4 id="tonase" class="my-1 tonase">{{ $tonase->kg }}</h4>
                                <h4 class="my-1 tonase2"></h4>
                                <p class="mb-0 font-13 text-danger"><strong>Kg</strong></p>
                            </div>
                            <div class="widgets-icons bg-light-danger text-danger ms-auto"><i class='bx bx-cart'></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--end row-->
        {{-- Filter --}}
        <div class="row row-cols-1 row-cols-md-2 row-cols-xl-3">
            <div class="col">
                <div class="card radius-10">
                    <div class="card-body">
                        <label for="inputAddress" class="form-label">Dari Tanggal</label>
                        <div class="col-12">
                            <input id="dari_tanggal" type="date" class="form-control" onchange="filter()">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card radius-10">
                    <div class="card-body">
                        <label for="inputAddress" class="form-label">Sampai Tanggal</label>
                        <div class="col-12">
                            <input id="sampai_tanggal" type="date" class="form-control" onchange="filter()">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card radius-10">
                    <div class="card-body">
                        <label for="inputAddress" class="form-label">Kondisi</label>
                        <div class="col-12">
                            <select class="form-select" id="filter-kondisi" onchange="filter()">
                                <option value="">Pilih Kondisi</option>
                                <option value="1">Order Masuk</option>
                                <option value="7">Cancelled</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>

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
                        <h6 class="mb-2">Data Pengiriman Barang</h6>
                        <div class="col-12">
                            @foreach ($cab as $ca)
                                @if (Auth::user()->id_cabang == $ca->id_cabang)
                                    <p>Daftar data pengiriman dari cabang <b>{{ $ca->nama_kota }}
                                            ({{ $ca->kode_area }})
                                        </b>
                                    </p>
                                @endif
                            @endforeach
                        </div>
                    </div>
                    <div class="dropdown ms-auto mb-2">
                        <a class="btn btn-success" href="/add/pengiriman/{{ $id_cabang }}">Tambah</a>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered" style="width:100%" id="pengiriman-dt">
                        <thead class="table-light">
                            <tr>
                                <th>No. Tracking</th>
                                <th>Nama Pengirim</th>
                                <th>Cabang Tujuan</th>
                                <th>Tanggal Masuk</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @else
        <p>Whoops!</p>
    @endif
@stop
@section('js')
    <script type="text/javascript">
        let list_pengiriman = [];

        const table = $("#pengiriman-dt").DataTable({
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
                url: "{{ url('') }}/pengiriman/{{ $id_cabang }}",
                type: "POST",
                data: function(d) {
                    d._token = "{{ csrf_token() }}",
                        d.dari = $("#dari_tanggal").val(),
                        d.sampai = $("#sampai_tanggal").val(),
                        d.kondisi = $("#filter-kondisi").val()
                }
            },
            "columnDefs": [{
                    "targets": 0,
                    "data": "no_resi",
                    "render": function(data, type, row, meta) {
                        // return meta.row + meta.settings._iDisplayStart + 1;
                        list_pengiriman[row.id_pengiriman] = row;
                        // console.log(list_pengiriman)
                        return data;
                    }
                }, {
                    "targets": 1,
                    "data": "nama_pengirim",
                    "render": function(data, type, row, meta) {
                        return data;
                        // console.log(recordsTotal)
                    }
                }, {
                    "targets": 2,
                    "data": "nama_kota",
                    "render": function(data, type, row, meta) {
                        return data;
                    }
                }, {
                    "targets": 3,
                    "data": "tgl_masuk",
                    "render": function(data, type, row, meta) {
                        return data;
                    }
                },
                {
                    "targets": 4,
                    "data": "status_sent",
                    "render": function(data, type, row, meta) {
                        var tampilan = ``;
                        if (data == 1) {
                            tampilan +=
                                `<div class="badge rounded-pill text-success bg-light-success p-2 text-uppercase px-3">` +
                                row.nama_status + `</div>`
                        } else if (data == 7) {
                            tampilan +=
                                `<div class="badge rounded-pill text-danger bg-light-danger p-2 text-uppercase px-3">` +
                                row.nama_status + `</div>`
                        } else {
                            tampilan +=
                                `<div class="badge rounded-pill text-info bg-light-info p-2 text-uppercase px-3">` +
                                row.nama_status + `</div>`
                        }
                        return tampilan;
                    }
                }, {
                    "targets": 5,
                    "sortable": false,
                    "data": "no_resi",
                    "render": function(data, type, row, meta) {
                        return `<div class="d-flex order-actions">
                            <a href="javascript:;" class="ms-3" onclick="toggleStatus('${row.id_pengiriman}')"><i class="fadeIn animated bx bx-reset"></i></a>
                            <a href="javascript:;" class="ms-3" ><i class="lni lni-printer"></i></a>		   
                        </div>`;
                    }
                    //  <a data-bs-toggle="modal" data-bs-target="#modalDetail"><i class='lni lni-eye'></i></a>
                },
            ]
        });

        function toggleStatus(id_pengiriman) {

            const _c = confirm("Apakah Anda yakin?")
            if (_c === true) {
                let pengiriman = list_pengiriman[id_pengiriman]
                let status_update = ''
                if (pengiriman.status_sent == 1) {
                    status_update = 7
                }
                $.ajax({
                    url: '{{ url('') }}/listpengiriman/update_status',
                    method: 'POST',
                    data: {
                        id_pengiriman: id_pengiriman,
                        status_sent: status_update,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(res) {
                        if (res === true) {
                            table.ajax.reload(null, false)
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        alert('Whops!')
                    }
                })
            }
        };

        fill_show();

        function fill_show(dari_tanggal, sampai_tanggal, filter_kondisi) {
            // console.log(dari_tanggal, sampai_tanggal, filter_kondisi)
            $.ajax({
                url: "{{ url('') }}/show_fill/{{ $id_cabang }}",
                method: 'POST',
                data: {
                    tgl_dari: dari_tanggal,
                    tgl_sampai: sampai_tanggal,
                    status: filter_kondisi,
                    _token: '{{ csrf_token() }}'
                },
                success: function(res) {
                    // let num = res[1].jumlah;
                    if (res[1].jumlah != null || res[2].kg != null) {
                        $('#transaksi').text(res[0]);
                        //Tonase
                        $('#tonase').addClass('tonase2').text(res[2].kg);
                        $(this).addClass('tonase2').removeClass('tonase');
                        //Total Omset
                        $('#omsetheading').addClass('omsetheading2').text('Rp' + res[1].jumlah);
                        $(this).addClass('omsetheading2').removeClass('omsetheading');
                        $('#p_omset').addClass('p_omset2').text(dari_tanggal + ' s.d. ' + sampai_tanggal);
                        $(this).addClass('p_omset2').removeClass('p_omset');
                    } else {
                        $('#transaksi').text(res[0]);
                        //Tonase
                        $('#tonase').addClass('tonase2').text('0');
                        $(this).addClass('tonase2').removeClass('tonase');
                        //Total Omset
                        $('#omsetheading').addClass('omsetheading2').text('Rp0');
                        $(this).addClass('omsetheading2').removeClass('omsetheading');
                        $('#p_omset').addClass('p_omset2').text(dari_tanggal + ' s.d. ' + sampai_tanggal);
                        $(this).addClass('p_omset2').removeClass('p_omset');
                    }
                    // console.log(res[2])

                },
                error: function(e) {
                    console.log(e)

                }
            })
        }

        function fill_show_kondisi(filter_kondisi) {
            // console.log(dari_tanggal, sampai_tanggal, filter_kondisi)
            $.ajax({
                url: "{{ url('') }}/show_fill_kondisi/{{ $id_cabang }}",
                method: 'POST',
                data: {
                    status: filter_kondisi,
                    _token: '{{ csrf_token() }}'
                },
                success: function(res) {
                    console.log(res[3])
                    $('#transaksi').text(res[0]);
                    //Tonase
                    if (res[3].kg != null || res[4].jumlah != null) {
                        //Total Omset
                        $('#omsetheading').addClass('omsetheading2').text('Rp' + res[4].jumlah);
                        $(this).addClass('omsetheading2').removeClass('omsetheading');
                        $('#p_omset').addClass('p_omset2').text(res[1].tgl_masuk + ' s.d. ' + res[2].tgl_masuk);
                        $(this).addClass('p_omset2').removeClass('p_omset');
                        $('#tonase').addClass('tonase2').text(res[3].kg);
                        $(this).addClass('tonase2').removeClass('tonase');
                    } else {
                        $('#tonase').addClass('tonase2').text('0');
                        $(this).addClass('tonase2').removeClass('tonase');
                        $('#omsetheading').addClass('omsetheading2').text('Rp0');
                    }

                },
                error: function(e) {
                    console.log(e)

                }
            })
        }

        function fill_show_all(dari_tanggal, sampai_tanggal, filter_kondisi) {
            // console.log(dari_tanggal, sampai_tanggal, filter_kondisi)
            $.ajax({
                url: "{{ url('') }}/show_fill_all/{{ $id_cabang }}",
                method: 'POST',
                data: {
                    tgl_dari: dari_tanggal,
                    tgl_sampai: sampai_tanggal,
                    status: filter_kondisi,
                    _token: '{{ csrf_token() }}'
                },
                success: function(res) {
                    // let num = res[1].jumlah;
                    if (res[1].jumlah != null || res[2].kg != null) {
                        $('#transaksi').text(res[0]);
                        //Tonase
                        $('#tonase').addClass('tonase2').text(res[2].kg);
                        $(this).addClass('tonase2').removeClass('tonase');
                        //Total Omset
                        $('#omsetheading').addClass('omsetheading2').text('Rp' + res[1].jumlah);
                        $(this).addClass('omsetheading2').removeClass('omsetheading');
                        $('#p_omset').addClass('p_omset2').text(dari_tanggal + ' s.d. ' + sampai_tanggal);
                        $(this).addClass('p_omset2').removeClass('p_omset');
                    } else {
                        $('#transaksi').text(res[0]);
                        //Tonase
                        $('#tonase').addClass('tonase2').text('0');
                        $(this).addClass('tonase2').removeClass('tonase');
                        //Total Omset
                        $('#omsetheading').addClass('omsetheading2').text('Rp0');
                        $(this).addClass('omsetheading2').removeClass('omsetheading');
                        $('#p_omset').addClass('p_omset2').text(dari_tanggal + ' s.d. ' + sampai_tanggal);
                        $(this).addClass('p_omset2').removeClass('p_omset');
                    }
                    // console.log(res[2])

                },
                error: function(e) {
                    console.log(e)

                }
            })
        }

        function filter() {
            table.ajax.reload(null, false)
            // console.log(recordsTotal)
            var dari_tanggal = $('#dari_tanggal').val();
            var sampai_tanggal = $('#sampai_tanggal').val();
            var filter_kondisi = $('#filter-kondisi').val();
            // var rowCount = $("#pengiriman-dt > tbody").find('tr').length;
            // console.log(filter_kondisi);
            if (dari_tanggal != '' && sampai_tanggal != '' && filter_kondisi != '') {
                fill_show_all(dari_tanggal, sampai_tanggal, filter_kondisi);
            } else if (filter_kondisi != '') {
                fill_show_kondisi(filter_kondisi);
                // alert('aa')
            } else if (dari_tanggal != '' || sampai_tanggal != '') {
                fill_show(dari_tanggal, sampai_tanggal, filter_kondisi);
            }

        }
    </script>
@stop
