<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    // Inventaris
    public function inventaris(){
        $data = User::where('roles', 'inventaris')->get();

        return response()->json([
            'status' => 'success',
            'message' => 'Data success full request',
            'data' => $data
        ], 201);
    }

    public function inventarisCreate(Request $request){
        $request->validate([
            'kode' => 'required',
            'username' => 'required',
        ]);

        $data = User::create([
            'kode' => 100 . $request->kode,
            'username' => $request->username,
            'password' => 'password',
            'roles' => 'inventaris'
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Create data success full',
            'data' => $data
        ], 201);
    }

    public function inventarisShow($id){
        $data = User::find($id);

        return response()->json([
            'status' => 'success',
            'message' => 'Show data success full',
            'data' => $data
        ]);
    }
    // inventaris end

    // kasir
    public function kasir(){
        $data = User::where('roles', 'kasir')->get();

        return response()->json([
            'status' => 'success',
            'message' => 'Data success full request',
            'data' => $data
        ], 201);
    }

    public function kasirCreate(Request $request){
        $request->validate([
            'kode' => 'required',
            'username' => 'required',
        ]);

        $data = User::create([
            'kode' => 100 . $request->kode,
            'username' => $request->username,
            'password' => 'password',
            'roles' => 'kasir'
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Create data success full',
            'data' => $data
        ], 201);
    }

    public function kasirShow($id){
        $data = User::find($id);

        return response()->json([
            'status' => 'success',
            'message' => 'Show data success full',
            'data' => $data
        ]);
    }
    // kasir end
}
