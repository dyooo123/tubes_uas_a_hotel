<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\KamarResource;
use Illuminate\Support\Facades\Validator;
use App\Models\Kamar;

class KamarController extends Controller
{

    public function index()
    {
        //get kamar
//        $kamar = Kamar::latest()->paginate(5);
//        //render view with posts
//        return view('kamar.index', compact('kamar'));
        $kamar = Kamar::latest()->get();
        return new KamarResource(true, 'List Data Kamar', $kamar);
    }

    public function create()
    {
        return view('kamar.create');
    }

    public function show($id)
    {
        //find post by ID
        $kamar = Kamar::find($id);
        return new KamarResource(true, 'mendapat Data Kamar', $kamar);
        //make response JSON
//        return response()->json([
//            'success' => true,
//            'message' => 'Detail Data Post',
//            'data'    => $kamar
//        ], 200);

    }

    public function store(Request $request)
    {
        //Validasi Formulir
//        $this->validate($request, [
//            'nama_kamar' => 'required',
//            'nama_manager' => 'required',
//            'jumlah_pegawai' => 'required'
//        ]);
//        //Fungsi Simpan Data ke dalam Database
//        Kamar::create([
//            'nama_kamar' => $request->nama_kamar,
//            'nama_manager' => $request->nama_manager,
//            'jumlah_pegawai' => $request->jumlah_pegawai
//        ]);
//        try{
//            //Mengisi variabel yang akan ditampilkan pada view mail
//            $content = [
//                'body' => $request->nama_kamar,
//            ];
//            //Mengirim email ke emailtujuan@gmail.com
//            Mail::to('sodhanatebri01@gmail.com')->send(new KamarMail($content));
//            //Redirect jika berhasil mengirim email
//            return redirect()->route('kamar.index')->with(['success'
//            => 'Data Berhasil Disimpan, email telah terkirim!']);
//        }catch(Exception $e){
//            //Redirect jika gagal mengirim email
//            return redirect()->route('kamar.index')->with(['success'
//            => 'Data Berhasil Disimpan, namun gagal mengirim email!']);
//        }
        $validator = Validator::make($request->all(), [
            'no_kamar' => 'required',
            'tipe_kamar' => 'required',
            'tipe_kasur' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        //Fungsi Post ke Database
        $kamar = Kamar::create([
            'no_kamar' => $request->no_kamar,
            'tipe_kamar' => $request->tipe_kamar,
            'tipe_kasur' => $request->tipe_kasur
        ]);
        return new KamarResource(true, 'Data Kamar Berhasil Ditambahkan!', $kamar);

    }


    public function edit($id)
    {
        $kamar = Kamar::find($id);
        return view('kamar.edit', compact('kamar'));
    }


    public function update(Request $request, $id)
    {
        $kamar = Kamar::find($id);
        //validate form
        $this->validate($request, [
            'no_kamar' => 'required',
            'tipe_kamar' => 'required',
            'tipe_kasur' => 'required'
        ]);


        $kamar->update([
            'no_kamar' => $request->no_kamar,
            'tipe_kamar' => $request->tipe_kamar,
            'tipe_kasur' => $request->tipe_kasur
        ]);
        return new KamarResource(true, 'Data Kamar Berhasil Diupdate!', $kamar);
        //return redirect()->route('kamar.index')->with(['success' => 'Data Berhasil Diubah!']);
    }


    public function destroy($id)
    {
        //find post by ID
        $kamar = Kamar::find($id);

        if($kamar) {

            //delete post
            $kamar->delete();

            return new KamarResource(true, 'Data Kamar Berhasil Dihapus!', $kamar);

        }

        //data post not found
        return new KamarResource(false, 'Data Kamar Gagal Dihapus!', $kamar);
    }
//    public function destroy($id)
//    {
//        $kamar = Kamar::find($id);
//        $kamar->delete();
//        return new KamarResource(true, 'Data Kamar Berhasil Dihapus!', $kamar);
//    }
}
