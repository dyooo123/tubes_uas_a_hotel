<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tamu;
use App\Models\Kamar;
use App\Http\Resources\TamuResource;

class TamuController extends Controller
{
    public function index()
    {
        //get posts
//        $tamu = Tamu::paginate(5);
//        //render view with posts
//        return view('tamu.index', compact('tamu'));
        $tamu = Tamu::with(['Kamar'])->latest()->get();
        return new TamuResource(true,'List Data Kamar', $tamu);
    }
    public function show($id)
    {
        //find post by ID
        $tamu = Tamu::find($id);
        return new TamuResource(true,'Mendapat Data Tamu', $tamu);
        //make response JSON
//        return response()->json([
//            'success' => true,
//            'message' => 'Detail Data Post',
//            'data'    => $kamar
//        ], 200);

    }

    public function create()
    {
        $kamar = Kamar::all();
        return view('tamu.create', compact('kamar'));
    }
    public function store(Request $request)
    {
        //Validasi Formulir

        $this->validate($request, [
            'nama_tamu' => 'required',
            'email' => 'required',
            'jenis_kelamin' => 'required',
            'no_telp' => 'required',
            'alamat' => 'required',
            'tanggal_lahir' => 'required',
            'tgl_checkin' => 'required',
            'tgl_checkout' => 'required',
            'id_kamar' => 'required',
        ],[
            'nama_tamu.required' => 'Nama Tamu tidak boleh kosong !',
            'email.required' => 'Email tidak boleh kosong !',
            'jenis_kelamin.required' => 'Kamar harus diisi !',
            'no_telp.required' => 'No Telfon tidak boleh kosong !',
            'tanggal_lahir.required' => 'Tanggal lahir tidak boleh kosong',
            'tgl_checkin.required' => 'Tanggal Cekin Harus Diisi',
            'tgl_checkout.required' => 'Tanggal Cekin Harus Diisi',
            'id_kamar.required' => 'Kamar harus diisi !',
        ]);
        //Fungsi Simpan Data ke dalam Database
        $tamu = Tamu::create([
            'nama_tamu'=> $request->nama_tamu,
            'email' => $request->email,
            'jenis_kelamin'=> $request->jenis_kelamin,
            'no_telp'=> $request->no_telp,
            'alamat' => $request->alamat,
            'tanggal_lahir' => $request->tanggal_lahir,
            'tgl_checkin' => $request->tgl_checkin,
            'tgl_checkout' => $request->tgl_checkout,
            'id_kamar' => $request->id_kamar,
        ]);

        return new TamuResource(true,'Data Tamu berhasil disimpan', $tamu);
//        try{
//            //Mengisi variabel yang akan ditampilkan pada view mail
//            $content = [
//                'body' => $request->nama_tamu,
//            ];
//            //Mengirim email ke emailtujuan@gmail.com
//            Mail::to('sodhanatebri01@gmail.com')->send(new TamuMail($content));
//            //Redirect jika berhasil mengirim email
//            return redirect()->route('tamu.index')->with(['success'
//            => 'Data Berhasil Disimpan, email telah terkirim!']);
//        }catch(Exception $e){
//            //Redirect jika gagal mengirim email
//            return redirect()->route('tamu.index')->with(['success'
//            => 'Data Berhasil Disimpan, namun gagal mengirim email!']);
//        }
    }


    public function edit($id)
    {
        $tamu = Tamu::find($id);
        $kamar = Kamar::all();
        return view('tamu.edit', compact('tamu','kamar'));
    }


    public function update(Request $request, $id)
    {
        $tamu = Tamu::find($id);
        //validate form
        $this->validate($request, [
            'nama_tamu' => 'required',
            'email' => 'required',
            'jenis_kelamin' => 'required',
            'no_telp' => 'required',
            'alamat' => 'required',
            'tanggal_lahir' => 'required',
            'tgl_checkin' => 'required',
            'tgl_checkout' => 'required',
        ]);


        $tamu->update([
            'nama_tamu'=> $request->nama_tamu,
            'email' => $request->email,
            'jenis_kelamin'=> $request->jenis_kelamin,
            'no_telp'=> $request->no_telp,
            'alamat' => $request->alamat,
            'tanggal_lahir' => $request->tanggal_lahir,
            'tgl_checkin' => $request->tgl_checkin,
            'tgl_checkout' => $request->tgl_checkout,
            'id_kamar' => $request->id_kamar,
        ]);

        return new TamuResource(true,'Data Tamu berhasil dubah', $tamu);
    }


    public function destroy($id)
    {
        $tamu = Tamu::find($id);
        $tamu->delete();
        return new TamuResource(true,'Data Tamu Berhasil Dihapus', $tamu);
    }
}
