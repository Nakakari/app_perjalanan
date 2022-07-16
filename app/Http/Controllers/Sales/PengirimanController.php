<?php

namespace App\Http\Controllers\Sales;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\M_jabatan;
use App\Models\M_cabang;
use App\Models\M_pelanggan;
use App\Models\M_pengiriman;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class PengirimanController extends Controller
{
    public function __construct(Request $request)
    {
        $this->M_pengiriman = new M_pengiriman();
    }

    public function index($id_cabang)
    {
        $cab = M_cabang::getAll();
        $jab =  M_jabatan::getJab();
        $totalOmset = M_pengiriman::getTotalOmset($id_cabang);
        $totalTransaksi = M_pengiriman::getTotalTransaksi($id_cabang);
        $tonase = M_pengiriman::getTotalTonase($id_cabang);
        $id_cabang = $id_cabang;
        return view('Sales.Pengiriman.v_pengiriman', compact('jab', 'cab', 'id_cabang', 'totalOmset', 'totalTransaksi', 'tonase'));
        // dd($totalTransaksi);
    }

    public function addPengiriman($id_cabang)
    {
        $id_cabang = $id_cabang;
        $jab =  M_jabatan::getJab();
        $cab = M_cabang::getAll();
        // $status_sent = M_pelanggan::getStatusSent();
        $status_sent = 1;
        $moda = M_pelanggan::getModa();
        $pembayaran = M_pelanggan::getPembayaran();
        $plgn = M_pelanggan::all();
        $plyn = M_pelanggan::getPelayanan();
        $kodeCab = M_cabang::getKode($id_cabang);
        $today = Carbon::today()->toDateString();

        $now = Carbon::now();
        $thnBln = $now->year . $now->month;
        $cek = M_pengiriman::count();
        $get = M_pengiriman::all()->last();
        if ($cek == 0) {
            $urut = '10' . $get->id_pengiriman;
            $nomor = strtoupper($kodeCab->kode_area) . '-' . $thnBln . $urut;
            // dd($nomor);
        } else {
            if (strlen($get->no_resi) <= 14 && substr($get->no_resi, -11) != strtoupper($kodeCab->kode_area)) {
                $urut = '10' . $get->id_pengiriman;
                $nomor = strtoupper($kodeCab->kode_area) . '-' . $thnBln . $urut;
            } else {
                $urut = '10' . $get->id_pengiriman;
                $nomor = strtoupper($kodeCab->kode_area) . '-' . $thnBln . $urut;
            }
        }
        // dd($kodeCab);

        //TNB-202207001

        return view('Sales.Pengiriman.v_addPengiriman', compact('jab', 'cab', 'status_sent', 'moda', 'nomor', 'pembayaran', 'plgn', 'plyn', 'id_cabang', 'today'));
    }

    public function kodePelanggan(Request $request)
    {
        $data = M_pelanggan::where('id_pelanggan', $request->get('id_pelanggan'))
            ->pluck('alamat', 'tlp_spv', 'id_pelanggan');
        return response()->json($data);
    }

    public function uploadDataPengiriman(Request $request, $id_cabang)
    {
        // dd(request()->all());
        $this->validate($request, [
            // 'no_resi' => ['required', 'string', 'max:255', 'unique:pengiriman'],
            'id_cabang_tujuan'  => 'required',
            'dari_cabang'  => 'required',
            'tgl_masuk'  => 'required',
            'nama_pengirim' => 'required',
            'alamat_pengirim' => 'required',
            'tlp_pengirim' => 'required',
            'status_sent'  => 'required',
            // 'id_pelanggan'  => 'required',
            'nama_penerima'  => 'required',
            'alamat_penerima'  => 'required',
            'no_penerima'  => 'required',
            'isi_barang'  => 'required',
            // 'berat'  => 'required',
            'koli'  => 'required',
            // 'no_ref'  => 'required',
            'no_pelayanan'  => 'required',
            'no_moda'  => 'required',
            'biaya'  => 'required',
            'tipe_pembayaran'  => 'required'
        ]);

        $id_cabang = $id_cabang;
        $data = new M_pengiriman();

        if (empty($request->get('no_resi_manual'))) {
            //no rsi manual 
            // dd(request()->all());
            if (empty($request->get('berat_kg'))) {
                //berat ASLI kosong
                $data->no_resi = $request->get('no_resi');
                $data->id_cabang_tujuan = $request->get('id_cabang_tujuan');
                $data->dari_cabang = $request->get('dari_cabang');
                $data->tgl_masuk = $request->get('tgl_masuk');
                $data->nama_pengirim = $request->get('nama_pengirim');
                $data->alamat_pengirim = $request->get('alamat_pengirim');
                $data->tlp_pengirim = $request->get('tlp_pengirim');
                $data->status_sent = $request->get('status_sent');
                $data->nama_penerima = $request->get('nama_penerima');
                $data->alamat_penerima = $request->get('alamat_penerima');
                $data->no_penerima = $request->get('no_penerima');
                $data->isi_barang = $request->get('isi_barang');
                $data->volume = $request->get('berat_m');
                $data->koli = $request->get('koli');
                // $data->no_ref = $request->get('no_ref');
                $data->no_pelayanan = $request->get('no_pelayanan');
                $data->no_moda = $request->get('no_moda');
                $data->biaya = $request->get('biaya');
                $data->tipe_pembayaran = $request->get('tipe_pembayaran');
                $data->save();
            } else {
                $data->no_resi = $request->get('no_resi');
                $data->id_cabang_tujuan = $request->get('id_cabang_tujuan');
                $data->dari_cabang = $request->get('dari_cabang');
                $data->tgl_masuk = $request->get('tgl_masuk');
                $data->nama_pengirim = $request->get('nama_pengirim');
                $data->alamat_pengirim = $request->get('alamat_pengirim');
                $data->tlp_pengirim = $request->get('tlp_pengirim');
                $data->status_sent = $request->get('status_sent');
                $data->nama_penerima = $request->get('nama_penerima');
                $data->alamat_penerima = $request->get('alamat_penerima');
                $data->no_penerima = $request->get('no_penerima');
                $data->isi_barang = $request->get('isi_barang');
                $data->berat = $request->get('berat_kg');
                $data->koli = $request->get('koli');
                // $data->no_ref = $request->get('no_ref');
                $data->no_pelayanan = $request->get('no_pelayanan');
                $data->no_moda = $request->get('no_moda');
                $data->biaya = $request->get('biaya');
                $data->tipe_pembayaran = $request->get('tipe_pembayaran');
                $data->save();
            }
        } else {
            // return 'ada isi manual';
            if (empty($request->get('berat_kg'))) {
                $data->no_resi = $request->get('no_resi_manual');
                $data->id_cabang_tujuan = $request->get('id_cabang_tujuan');
                $data->dari_cabang = $request->get('dari_cabang');
                $data->tgl_masuk = $request->get('tgl_masuk');
                $data->nama_pengirim = $request->get('nama_pengirim');
                $data->alamat_pengirim = $request->get('alamat_pengirim');
                $data->tlp_pengirim = $request->get('tlp_pengirim');
                $data->status_sent = $request->get('status_sent');
                $data->nama_penerima = $request->get('nama_penerima');
                $data->alamat_penerima = $request->get('alamat_penerima');
                $data->no_penerima = $request->get('no_penerima');
                $data->isi_barang = $request->get('isi_barang');
                $data->volume = $request->get('berat_m');
                $data->koli = $request->get('koli');
                // $data->no_ref = $request->get('no_ref');
                $data->no_pelayanan = $request->get('no_pelayanan');
                $data->no_moda = $request->get('no_moda');
                $data->biaya = $request->get('biaya');
                $data->tipe_pembayaran = $request->get('tipe_pembayaran');
                $data->save();
            } else {
                $data->no_resi = $request->get('no_resi_manual');
                $data->id_cabang_tujuan = $request->get('id_cabang_tujuan');
                $data->dari_cabang = $request->get('dari_cabang');
                $data->tgl_masuk = $request->get('tgl_masuk');
                $data->nama_pengirim = $request->get('nama_pengirim');
                $data->alamat_pengirim = $request->get('alamat_pengirim');
                $data->tlp_pengirim = $request->get('tlp_pengirim');
                $data->status_sent = $request->get('status_sent');
                $data->nama_penerima = $request->get('nama_penerima');
                $data->alamat_penerima = $request->get('alamat_penerima');
                $data->no_penerima = $request->get('no_penerima');
                $data->isi_barang = $request->get('isi_barang');
                $data->volume = $request->get('berat_m');
                $data->koli = $request->get('koli');
                // $data->no_ref = $request->get('no_ref');
                $data->no_pelayanan = $request->get('no_pelayanan');
                $data->no_moda = $request->get('no_moda');
                $data->biaya = $request->get('biaya');
                $data->tipe_pembayaran = $request->get('tipe_pembayaran');
                $data->save();
            }
        }

        return redirect('pengiriman/' . $id_cabang)->with('pesan', 'Selamat! Data berhasil disimpan.');
    }

    public function listPengiriman($id_cabang)
    {
        $columns = [
            'id_pengiriman', 'no_resi', 'id_cabang', 'status_sent', 'id_pelanggan', 'nama_penerima', 'alamat_penerima', 'no_penerima',
            'isi_barang', 'berat', 'koli', 'no_ref', 'no_pelayanan', 'no_moda', 'biaya', 'tipe_pembayaran',
            'nama_pengirim', 'alamat_pengirim', 'tlp_pengirim', 'dari_cabang'
        ];

        $orderBy = $columns[request()->input("order.0.column")];
        // \Carbon\Carbon::setLocale('id');
        // echo \Carbon\Carbon::now()->format('l, d F Y H:i');
        $data = M_pengiriman::select([
            // '*'
            'pengiriman.id_pengiriman',
            'pengiriman.no_resi',
            'pengiriman.id_cabang_tujuan',
            'pengiriman.dari_cabang',
            'pengiriman.nama_pengirim',
            'pengiriman.alamat_pengirim',
            'pengiriman.tlp_pengirim',
            'pengiriman.status_sent',
            'tbl_status_pengiriman.nama_status',
            'pengiriman.id_pelanggan',
            'pengiriman.tgl_masuk',
            'pengiriman.nama_penerima',
            'pengiriman.alamat_penerima',
            'pengiriman.no_penerima',
            'pengiriman.isi_barang',
            'pengiriman.berat',
            'pengiriman.koli',
            'pengiriman.no_ref',
            'pengiriman.no_pelayanan',
            'pengiriman.no_moda',
            'pengiriman.biaya',
            'pengiriman.tipe_pembayaran',
            // 'pelanggan.nama_perusahaan',
            'cabang.nama_kota'
        ])
            ->join('cabang', 'pengiriman.id_cabang_tujuan', '=', 'cabang.id_cabang')
            // ->join('pelanggan', 'pelanggan.id_pelanggan', '=', 'pengiriman.id_pelanggan')
            ->join('tbl_status_pengiriman', 'tbl_status_pengiriman.id_stst_pngrmn', '=', 'pengiriman.status_sent')
            ->where('pengiriman.dari_cabang', $id_cabang)
            // ->orWhere('pengiriman.id_cabang')
            ->orderBy('id_pengiriman', "asc");

        $recordsFiltered = $data->get()->count(); //menghitung data yang sudah difilter

        if (request()->input("search.value")) {
            $data = $data->where(function ($query) {
                $query->whereRaw('LOWER(pengiriman.no_resi) like ?', ['%' . strtolower(request()->input("search.value")) . '%'])
                    ->orWhereRaw('LOWER(pengiriman.nama_pengirim) like ?', ['%' . strtolower(request()->input("search.value")) . '%'])
                    ->orWhereRaw('LOWER(cabang.nama_kota) like ?', ['%' . strtolower(request()->input("search.value")) . '%']);
            });
        }

        if (request()->input('dari') != null || request()->input('sampai') != null) {
            $data = $data->whereBetween('pengiriman.tgl_masuk', [request()->dari, request()->sampai]);
        }

        if (request()->input('kondisi') != null) {
            $data = $data->where('pengiriman.status_sent', request()->kondisi);
        }

        $data = $data
            ->skip(request()->input('start'))
            ->take(request()->input('length'))
            ->orderBy($orderBy, request()->input("order.0.dir"))
            ->get();
        $recordsTotal = $data->count();

        return response()->json([
            'draw' => request()->input('draw'),
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsFiltered,
            'data' => $data,
            'all_request' => request()->all()
        ]);
    }

    public function updateStatus(Request $request)
    {
        $pengiriman = M_pengiriman::find($request->input('id_pengiriman'));
        $pengiriman->status_sent = $request->status_sent;
        $pengiriman->save();
        return response()->json(true);
    }

    public function showFill($id_cabang)
    {
        if (request()->input('tgl_dari') != null || request()->input('tgl_sampai') != null) {
            $dataWaktu = M_pengiriman::whereBetween('pengiriman.tgl_masuk', [request()->tgl_dari, request()->tgl_sampai])->where('dari_cabang', $id_cabang)->count();
            $jumlah = M_pengiriman::select(DB::raw("SUM(biaya) as jumlah"))->whereBetween('pengiriman.tgl_masuk', [request()->tgl_dari, request()->tgl_sampai])->where('dari_cabang', $id_cabang)->first();
            $berat = M_pengiriman::select(DB::raw("SUM(berat) as kg"))->whereBetween('pengiriman.tgl_masuk', [request()->tgl_dari, request()->tgl_sampai])->where('dari_cabang', $id_cabang)->first();
            return [$dataWaktu, $jumlah, $berat];
        }
    }

    public function showFillAll($id_cabang)
    {
        if (request()->input('tgl_dari') != null && request()->input('tgl_sampai') != null && request()->input('status') != null) {
            $dataWaktu = M_pengiriman::whereBetween('pengiriman.tgl_masuk', [request()->tgl_dari, request()->tgl_sampai])->where('pengiriman.status_sent', request()->status)->where('dari_cabang', $id_cabang)->count();
            $jumlah = M_pengiriman::select(DB::raw("SUM(biaya) as jumlah"))->whereBetween('pengiriman.tgl_masuk', [request()->tgl_dari, request()->tgl_sampai])->where('pengiriman.status_sent', request()->status)->where('dari_cabang', $id_cabang)->first();
            $berat = M_pengiriman::select(DB::raw("SUM(berat) as kg"))->whereBetween('pengiriman.tgl_masuk', [request()->tgl_dari, request()->tgl_sampai])->where('pengiriman.status_sent', request()->status)->where('dari_cabang', $id_cabang)->first();
            return [$dataWaktu, $jumlah, $berat];
        }
    }

    public function showFillKondisi($id_cabang)
    {
        if (request()->input('status') != null) {
            $data = M_pengiriman::where('pengiriman.status_sent', request()->status)->where('dari_cabang', $id_cabang)->count();
            $tgl_awal = M_pengiriman::select('pengiriman.tgl_masuk')->where('pengiriman.status_sent', request()->status)->where('dari_cabang', $id_cabang)->first();
            $tgl_akhir = M_pengiriman::select('pengiriman.tgl_masuk')->where('pengiriman.status_sent', request()->status)->where('dari_cabang', $id_cabang)->latest('tgl_masuk')->first();
            $berat = M_pengiriman::select(DB::raw("SUM(berat) as kg"))->where('pengiriman.status_sent', request()->status)->where('dari_cabang', $id_cabang)->first();
            $jumlah = M_pengiriman::select(DB::raw("SUM(biaya) as jumlah"))->where('pengiriman.status_sent', request()->status)->where('dari_cabang', $id_cabang)->first();
            return [$data, $tgl_awal, $tgl_akhir, $berat, $jumlah];
        }
    }
}
