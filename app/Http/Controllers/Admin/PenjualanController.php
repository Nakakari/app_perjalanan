<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\M_jabatan;

class PenjualanController extends Controller
{
    public function index()
    {
        $data = [

            'jab' => M_jabatan::getJab(),

        ];
        return view('Admin.Penjualan.v_penjualan', $data);
        // dd($data['usr']);
    }

    public function detailPenjualan()
    {
        return 'okay';
    }
}
