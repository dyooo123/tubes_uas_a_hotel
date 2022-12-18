<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class UserController extends Controller
{
    public function index() //method read atau menampilkan semua data user
    {
        $users = User::all(); //mengambil semua data user

        if(count($users) > 0){
            return response([
                'message' => 'Retrieve All Success',
                'data' => $users
            ], 200);
        } //return data semua user dalam bentuk json

        return response([
            'message' => 'Empty',
            'data' => null
        ], 400); //return message data course kosong
    }


    public function show() //method search atau menampilkan sebuah data user
    {
        $user = auth()->user();
        //$user = User::find($id); //mencari data user berdasarkan id

        if(!is_null($user)) {
            return response([
                'message' => 'Retrieve User Success',
                'data' => $user
            ], 200);
        }

        return response([
            'message' => 'User Not Found',
            'data' => null
        ], 404);
    }

    public function update(Request $request) //method update atau mengubah sebuah data user
    {
        $user = auth()->user();
//        if(is_null($user)) {
//            return response([
//                'message' => 'User Not Found',
//                'data' => null
//            ], 404);
//        }

        $updateData = $request->all();
        $validate = Validator::make($updateData, [
            'name' => 'required|max:60',
            'email' => 'required|email:rfc,dns|unique:users',
            'password' => 'required|min:8'
        ]);

        $updateData['password'] = bcrypt($request->password); //untuk meng-enkripsi password
        if($validate->fails())
            return response(['message' => $validate->errors()], 400);


        $user = User::find($user->id);

        $user->name = $updateData['name'];
        $user->email = $updateData['email'];
        $user->password = $updateData['password'];
        if($user->save()) {
            return response([
                'message' => 'Update User Success',
                'data' => $user
            ], 200);
        }

        return response([
            'message' => 'Update User Failed',
            'data' => null
        ], 400);
    }


    public function destroy($id) //method delete atau menghapus sebuah data user
    {
        $user = User::find($id);

        if(is_null($user)) {
            return response([
                'message' => 'User Not Found',
                'data' => null
            ], 404);
        }

        if($user->delete()) {
            return response([
                'message' => 'Delete User Success',
                'data' => $user
            ], 200);
        }

        return response([
            'message' => 'Delete User Failed',
            'data' => null
        ], 400);
    }
}
