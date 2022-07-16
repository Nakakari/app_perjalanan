<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\M_pengguna;
use App\Models\M_cabang;
use App\Models\M_jabatan;

class JabatanController extends Controller
{
    public function index()
    {
        $data = [
            'cab' => M_cabang::getAll(),
            'jab' => M_jabatan::getJab(),
            'usr' => M_pengguna::getAll()
        ];
        return view('Admin.Jabatan.v_jabatan', $data);
        // dd($data['usr']);
    }

    public function jenisJabatan()
    {
        $columns = [
            'nama_jabatan',
            'id_jabatan'
        ];
        $orderBy = $columns[request()->input("order.0.column")];
        $data = M_jabatan::select('*');

        $recordsFiltered = $data->get()->count(); //menghitung data yang sudah difilter

        if (request()->input("search.value")) {
            $data = $data->where(function ($query) {
                $query->whereRaw('LOWER(jabatan.nama_jabatan) like ?', ['%' . strtolower(request()->input("search.value")) . '%']);
            });
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

    public function addJabatan(Request $request)
    {
        $this->validate($request, [
            'nama_jabatan' => ['required', 'string', 'max:255'],
        ]);

        $data = new M_jabatan();
        $data->nama_jabatan = $request->get('nama_jabatan');

        $data->save();

        return redirect()->back()->with('pesan', 'Data Berhasil Ditambah!!');
    }
}
