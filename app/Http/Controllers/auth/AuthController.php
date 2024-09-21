<?php

namespace App\Http\Controllers\auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\DataUser;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $user = User::where('username', $request->username)->first();

        if (!$user || !Auth::attempt($request->only('username', 'password'))) {
            return response()->json([
                'message' => 'Invalid login details'
            ], 401);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'role' => $user->roles,
        ]);
    }

    public function forgoat(Request $request){
        $request->validate([
            "password" => 'required|min:8',
            "konfir" => 'required|min:8'
        ]);

        if ($request->konfir == $request->password){
            $data = User::find($request->user()->id);
            $data->updated([
                "password" => $request->password
            ]);

            return response()->json([
                "status" => "success",
                "message" => "Password Berhasil diubah",
            ]);
        }else{
            return response()->json([
                "status" => "gagal",
                "message" => "Konfirmasi Password Harus Sama Dengan Password"
            ]);
        }
    }

    public function profile(Request $request){
        $data2 = $request->user();
        $data = DataUser::where('user_id', $data2->id)->get();

        return response()->json([
            "status" => "success",
            "data" => $data,
            "data2" => $data2
        ]);
    }

    public function updateOrCreate(Request $request){
        $request->validate([
            'nama' => 'required',
            'email' => 'required|email|unique:data_users,email,' . $request->user()->id . ',user_id', // Unik kecuali untuk user saat ini
            'phone' => 'required|regex:/^[0-9]+$/|unique:data_users,phone,' . $request->user()->id . ',user_id', // Unik kecuali untuk user saat ini
            'jenis_kelamin' => 'required',
            'alamat' => 'required',
            'alamat_toko' => 'nullable',
            'phone_toko' => 'nullable|regex:/^[0-9]+$/',
            'nama_toko' => 'nullable'
        ]);

        // Gunakan updateOrCreate
        $data = DataUser::updateOrCreate(
            [
                'user_id' => $request->user()->id
            ],
            [
                'nama' => $request->nama,
                'email' => $request->email,
                'phone' => $request->phone,
                'jenis_kelamin' => $request->jenis_kelamin,
                'alamat' => $request->alamat,
                'alamat_toko' => $request->alamat_toko,
                'phone_toko' => $request->phone_toko,
                'nama_toko' => $request->nama_toko,
            ]
        );

        return response()->json([
            'status' => 'success',
            'data' => $data
        ], 200);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logged out successfully'
        ]);
    }
}
