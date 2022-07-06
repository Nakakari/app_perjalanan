<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\M_pengguna;
use App\Models\M_cabang;
use App\Models\M_jabatan;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class PenggunaController extends Controller
{
    public function index()
    {
        $data = [
            'cab' => M_cabang::getAll(),
            'jab' => M_jabatan::getJab(),
            'usr' => M_pengguna::getAll()
        ];
        return view('Admin.Pengguna.v_akun', $data);
    }

    public function jenisJabatan()
    {
        $columns = [
            'nama_jabatan',
        ];
        $orderBy = $columns[request()->input("order.0.column")];
        $data = M_jabatan::select('*');

        $recordsFiltered = $data->get()->count(); //menghitung data yang sudah difilter

        if (request()->input("search.value")) {
            $data = $data->where(function ($query) {
                $query->whereRaw('LOWER(cabang.nama_kota) like ?', ['%' . strtolower(request()->input("search.value")) . '%']);
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

    public function listPengguna()
    {
        $columns = [
            'name',
            'id',
        ];
        $orderBy = $columns[request()->input("order.0.column")];
        $data = M_pengguna::select([
            'users.name',
            'users.peran',
            'users.email',
            'users.password',
            'users.file_foto',
            'users.tgl_lhr',
            'users.alamat',
            'users.id_cabang',
            'users.id',
            'cabang.nama_kota',
            'cabang.kode_area',
            'jabatan.nama_jabatan'
        ])
            ->join('cabang', 'users.id_cabang', '=', 'cabang.id_cabang')
            ->join('jabatan', 'users.peran', '=', 'jabatan.id_jabatan')
            ->orderBy('id', "asc");

        $recordsFiltered = $data->get()->count(); //menghitung data yang sudah difilter

        if (request()->input("search.value")) {
            $data = $data->where(function ($query) {
                $query->whereRaw('LOWER(cabang.nama_kota) like ?', ['%' . strtolower(request()->input("search.value")) . '%'])
                    ->orWhereRaw('LOWER(cabang.kode_area) like ?', ['%' . strtolower(request()->input("search.value")) . '%'])
                    ->orWhereRaw('LOWER(users.name) like ?', ['%' . strtolower(request()->input("search.value")) . '%'])
                    ->orWhereRaw('LOWER(users.alamat) like ?', ['%' . strtolower(request()->input("search.value")) . '%'])
                    ->orWhereRaw('LOWER(users.email) like ?', ['%' . strtolower(request()->input("search.value")) . '%'])
                    ->orWhereRaw('LOWER(jabatan.nama_jabatan) like ?', ['%' . strtolower(request()->input("search.value")) . '%']);
            });
        }

        $data = $data
            ->skip(request()->input('start'))
            ->take(request()->input('length'))
            ->orderBy($orderBy, request()->input("order.0.dir"))
            ->get();
        $recordsTotal = $data->count();

        // dd($data);

        return response()->json([
            'draw' => request()->input('draw'),
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsFiltered,
            'data' => $data,
            'all_request' => request()->all()
        ]);
    }

    public function kodeArea(Request $request)
    {
        $data = M_cabang::where('id_cabang', $request->get('id_cabang'))
            ->pluck('kode_area', 'id_cabang');
        return response()->json($data);
    }

    public function addPengguna(Request $request)
    {
        $this->validate($request, [
            'name' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string', 'min:8'],
            'email' => ['required', 'string', 'email', 'max:255'],
            "id_cabang" => 'required',
            "tgl_lhr" => 'required',
            "alamat" => 'required',
            "id_jabatan" => 'required',
            'file_foto' => 'required|file|image|mimes:jpeg,png,jpg',
        ]);

        $data = new M_pengguna();
        $data->name = $request->get('name');
        $data->password = Hash::make($request->get('password'));
        $data->email = $request->get('email');
        $data->id_cabang = $request->get('id_cabang');
        $data->tgl_lhr = $request->get('tgl_lhr');
        $data->alamat = $request->get('alamat');
        $data->alamat = $request->get('alamat');
        $data->peran = $request->get('id_jabatan');
        $file = $request->file('file_foto');

        $nama_file = time() . "_" . $file->getClientOriginalName();

        // isi dengan nama folder tempat kemana file diupload
        $tujuan_upload = 'foto_pengguna';
        $file->move($tujuan_upload, $nama_file);

        $data->save();

        return redirect()->back()->with('pesan', 'Data Berhasil Ditambah!!');
    }

    public function hapusPengguna($id)
    {
        DB::table('users')->where('id', $id)->delete();
        return redirect()->back()->with('pesan', 'Data Berhasil Ditambah!!');
    }
}
