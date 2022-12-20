<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\KaryawanResource;
use Illuminate\Support\Facades\Validator;
use App\Models\Karyawan;

class KaryawanController extends Controller
{
    public function index()
    {

        $karyawan = Karyawan::latest()->get();
        return new KaryawanResource(true, 'List Data Karyawan', $karyawan);
    }

    public function create()
    {
        return view('karyawan.create');
    }

    public function show($id)
    {
        //find post by ID
        $karyawan = Karyawan::find($id);
        return new KaryawanResource(true, 'mendapat Data Karyawan', $karyawan);


    }

    public function store(Request $request)
    {
     
        $validator = Validator::make($request->all(), [
            'nama_karyawan' => 'required',
            'jenis_kelamin' => 'required',
            'alamat' => 'required',
            'no_telp' => 'required',
            'gaji' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        //Fungsi Post ke Database
        $karyawan = Karyawan::create([
            'nama_karyawan' => $request->nama_karyawan,
            'jenis_kelamin' => $request->jenis_kelamin,
            'alamat' => $request->alamat,
            'no_telp' => $request->no_telp,
            'gaji' => $request->gaji

        ]);
        return new KaryawanResource(true, 'Data Karyawan Berhasil Ditambahkan!', $karyawan);

    }


    public function edit($id)
    {
        $karyawan = Karyawan::find($id);
        return view('karyawan.edit', compact('karyawan'));
    }


    public function update(Request $request, $id)
    {
        $karyawan = Karyawan::find($id);
        //validate form
        $this->validate($request, [
            'nama_karyawan' => 'required',
            'jenis_kelamin' => 'required',
            'alamat' => 'required',
            'no_telp' => 'required',
            'gaji' => 'required'
        ]);


        $karyawan->update([
            'nama_karyawan' => $request->nama_karyawan,
            'jenis_kelamin' => $request->jenis_kelamin,
            'alamat' => $request->alamat,
            'no_telp' => $request->no_telp,
            'gaji' => $request->gaji
        ]);
        return new KaryawanResource(true, 'Data Karyawan Berhasil Diupdate!', $karyawan);
        //return redirect()->route('karyawan.index')->with(['success' => 'Data Berhasil Diubah!']);
    }


    public function destroy($id)
    {
        //find post by ID
        $karyawan = Karyawan::find($id);

        if($karyawan) {

            //delete post
            $karyawan->delete();

            return new KaryawanResource(true, 'Data Karyawan Berhasil Dihapus!', $karyawan);

        }

        //data post not found
        return new KaryawanResource(false, 'Data Karyawan Gagal Dihapus!', $karyawan);
    }

}
