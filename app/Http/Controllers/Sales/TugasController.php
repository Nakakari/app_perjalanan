<?php

namespace App\Http\Controllers\Sales;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\M_jabatan;
use App\Models\M_cabang;
use App\Models\M_pelanggan;
use App\Models\M_pengiriman;

class TugasController extends Controller
{
    //
    public function index($id_cabang)
    {
        // $cab = M_cabang::getAll();
        $jab =  M_jabatan::getJab();
        $totalOmset = M_pengiriman::getTotalOmset($id_cabang);
        $totalTransaksi = M_pengiriman::getTotalTransaksi($id_cabang);
        $id_cabang = $id_cabang;
        return view('Sales.daftarTugas.v_daftarTugas', compact('jab', 'id_cabang', 'totalOmset', 'totalTransaksi'));
    }
}
