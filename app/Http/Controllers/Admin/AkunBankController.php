<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\M_jabatan;
use App\Models\M_akunBank;

class AkunBankController extends Controller
{
    public function index()
    {
        $data = [
            'bank' => M_akunBank::getAll(),
            'jab' => M_jabatan::getJab(),
        ];
        return view('Admin.Bank.v_akunbank', $data);
        // dd($data['bank']);
    }

    public function listBank()
    {
        // dd(request()->all());
        $columns = [
            'nama_bank',
            'id_bank',
            'no_rek',
            'an'
        ];
        $orderBy = $columns[request()->input("order.0.column")];
        $data = M_akunBank::select('*');

        $recordsFiltered = $data->get()->count(); //menghitung data yang sudah difilter

        if (request()->input("search.value")) {
            $data = $data->where(function ($query) {
                $query->whereRaw('LOWER(bank.nama_bank) like ?', ['%' . strtolower(request()->input("search.value")) . '%'])
                    ->orWhereRaw('LOWER(bank.no_rek) like ?', ['%' . strtolower(request()->input("search.value")) . '%']);
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

    public function addBank(Request $request)
    {
        $this->validate($request, [
            'nama_bank' => ['required', 'string', 'max:255', 'unique:bank'],
            'no_rek' => 'required',
            'an' => 'required',
        ]);

        $data = new M_akunBank();
        $data->nama_bank = $request->get('nama_bank');
        $data->no_rek = $request->get('no_rek');
        $data->an = $request->get('an');

        $data->save();

        return redirect()->back()->with('pesan', 'Data Berhasil Ditambah!!');
    }
}
