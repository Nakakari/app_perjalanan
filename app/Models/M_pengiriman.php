<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class M_pengiriman extends Model
{
    use HasFactory;
    protected $fillable = [
        'no_resi', 'id_cabang', 'status_sent', 'id_pelanggan', 'nama_penerima', 'alamat_penerima', 'no_penerima', 'kota_penerima',
        'isi_barang', 'berat', 'koli', 'no_ref', 'no_pelayanan', 'no_moda', 'biaya', 'tipe_pembayaran', 'nama_pengirim', 'kota_pengirim',
        'alamat_pengirim', 'tlp_pengirim', 'tgl_masuk', 'dari_cabang'
    ];
    protected $table = 'pengiriman';
    protected $primaryKey = 'id_pengiriman';
    public $timestamps = false;

    public static function getTotalOmset($id_cabang)
    {
        return DB::table('pengiriman')
            ->select(
                DB::raw("SUM(biaya) as jumlah")
            )
            ->where('dari_cabang', $id_cabang)
            ->first();
    }

    public static function getTotalTonase($id_cabang)
    {
        return DB::table('pengiriman')
            ->select(
                DB::raw("SUM(berat) as kg")
            )
            ->where('dari_cabang', $id_cabang)
            ->first();
    }

    public static function getTotalTransaksi($id_cabang)
    {
        return DB::table('pengiriman')
            ->where('dari_cabang', $id_cabang)
            ->count();
    }

    public static function getDetailData($id_pengiriman)
    {
        return DB::table('pengiriman')
            ->select(
                '*'
            )
            ->join('cabang', 'pengiriman.id_cabang_tujuan', '=', 'cabang.id_cabang')
            ->join('tipe_pembayaran', 'tipe_pembayaran.id_pembayaran', '=', 'pengiriman.tipe_pembayaran')
            ->where('id_pengiriman', $id_pengiriman)
            ->first();
    }
}
