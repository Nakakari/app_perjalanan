<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class M_cabang extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama_kota', 'kode_area'
    ];
    protected $table = 'cabang';
    protected $primaryKey = 'id_cabang';
    public $timestamps = false;

    public static function getAll()
    {
        return DB::table('cabang')
            ->select('*')
            ->get();
    }

    public static function getKode($id_cabang)
    {
        return DB::table('cabang')
            ->select('kode_area')
            ->where('id_cabang', $id_cabang)
            ->first();
    }
}
