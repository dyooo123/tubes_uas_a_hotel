<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request){
        $registrationData = $request->all(); //mengambil seluruh data input dan menyimpan dalam variabel registrationData

        $validate = Validator::make($registrationData, [
            'name' => 'required|max:60',
            'email' => 'required|email:rfc,dns|unique:users',
            'password' => 'required|min:8',
//            'password' => 'required|min:8|regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!$#%]).*$/',
//            'image' => 'required|file'

        ]); //rule validasi input saat register

//        $path = $request->file('image')->store('users','public');
//        $registrationData['image']=basename($path);
        if($validate->fails()) //mengecek apakah inputan sudah sesuai dengan rule validasi
            return response(['message' => $validate->errors()], 400); //mengembalikan error validasi input

        $registrationData['password'] = bcrypt($request->password);

        $user = User::create($registrationData); //membuat user baru
        $user->sendEmailVerificationNotification();

        return response([
            'status' => true,
            'message' => 'Register Success',
            'user' => $user,
            'token' => $user->createToken("API TOKEN")->plainTextToken
        ], 200); //return data user dalam bentuk json
    }

    public function login(Request $request){
        $loginData = $request->all();

        $validate = Validator::make($loginData, [
            'email' => 'required|email:rfc,dns',
            'password' => 'required|min:8',
        ]);

        if($validate->fails())
            return response(['message' => $validate->errors()], 400);

        if(!Auth::attempt($loginData))
            return response(['message' => 'Invalid Credentials'], 401); //mengembalikan error gagal login

//        $user = Auth::user();
//        $token = $user->createToken('Authentication Token')->accessToken; //generate token
        $user = User::where('email', $request->email)->first();
        if (!$user->hasVerifiedEmail()) {
            return response()->json([
                'status' => false,
                "message" => "Email isn't' verified"
            ], 400);
        }
        return response([
            'status' => true,
            'message' => 'User Logged In Successfully',
            'token' => $user->createToken("API TOKEN")->plainTextToken
        ]); //return data user dan token dalam bentuk json

    }

    public function logout(Request $request){
        try{
            auth()->user()->currentAccessToken()->delete();

            return response()->json([
                'status' => true,
                'message' => 'User Logged Out Successfully',
            ], 200);
        }catch (\Exception $e){
            return response([
                'message' => $e->getMessage()
            ]);
        }
    }

}
