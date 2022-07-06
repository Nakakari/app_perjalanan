<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\M_cabang;

class CabangController extends Controller
{
    public function index()
    {
        $data = [
            'cab' => M_cabang::getAll()
        ];
        return view('Admin.Cabang.v_cabang', $data);
    }

    public function listCabang()
    {
        // dd(request()->all());
        $columns = [
            'nama_kota',
            'id_cabang',
            'kode_area'
        ];
        $orderBy = $columns[request()->input("order.0.column")];
        $data = M_cabang::select('*');

        $recordsFiltered = $data->get()->count(); //menghitung data yang sudah difilter

        if (request()->input("search.value")) {
            $data = $data->where(function ($query) {
                $query->whereRaw('LOWER(cabang.nama_kota) like ?', ['%' . strtolower(request()->input("search.value")) . '%'])
                    ->orWhereRaw('LOWER(cabang.kode_area) like ?', ['%' . strtolower(request()->input("search.value")) . '%']);
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

    public function addCabang(Request $request)
    {
        $this->validate($request, [
            'nama_kota' => ['required', 'string', 'max:255', 'unique:cabang'],
            "kode_area" => 'required'
        ]);

        $data = new M_cabang();
        $data->nama_kota = $request->get('nama_kota');
        $data->kode_area = $request->get('kode_area');

        $data->save();

        return redirect()->back()->with('pesan', 'Data Berhasil Ditambah!!');
    }

    public function updateCabang(Request $request, $id_cabang)
    {
        $this->validate($request, [
            'nama_kota' => ['required', 'string', 'max:255', 'unique:cabang'],
            'kode_area' => 'required'
        ]);

        $data =  M_cabang::find($id_cabang);
        $data->nama_kota = $request->get('nama_kota');
        $data->kode_area = $request->get('kode_area');

        $data->update();

        return redirect()->back()->with('pesan', 'Data Berhasil Diupdate!!');
    }

    public function hapusCabang($id_cabang)
    {
        $item = M_cabang::findOrFail($id_cabang);
        $item->delete();
        return redirect()->back()->with('pesan', 'Data Berhasil Dihapus!!');
    }
}
