<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Inventaris;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class InventarisController extends Controller
{
    public function tambahInventaris(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_barang' => 'required',
            'jumlah' => 'required|integer|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'data' => null,
                'message' => 'Invalid input',
            ], 400);
        }

        $inventaris = Inventaris::where('nama_barang', $request->nama_barang)->first();

        if ($inventaris) {
            $inventaris->jumlah += $request->jumlah;
            $inventaris->save();
        } else {
            $inventaris = new Inventaris();
            $inventaris->nama_barang = $request->nama_barang;
            $inventaris->jumlah = $request->jumlah;
            $inventaris->user_id = Auth::user()->id;
            $inventaris->save();
        }

        return response()->json([
            'status' => true,
            'data' => $inventaris,
            'message' => 'Inventaris added successfully',
        ], 200);
    }

    public function updateInventaris(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'inventaris_id' => 'required|exists:inventaris,id',
            'nama_barang' => 'required',
            'jumlah' => 'required|integer|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'data' => null,
                'message' => 'Invalid input',
            ], 400);
        }

        $inventaris = Inventaris::findOrFail($request->inventaris_id);
        $inventaris->nama_barang = $request->nama_barang;
        $inventaris->jumlah = $request->jumlah;
        $inventaris->save();

        return response()->json([
            'status' => true,
            'data' => $inventaris,
            'message' => 'Inventaris updated successfully',
        ], 200);
    }

    public function hapusInventaris(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'inventaris_id' => 'required|exists:inventaris,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'data' => null,
                'message' => 'Invalid input',
            ], 400);
        }

        $inventaris = Inventaris::findOrFail($request->inventaris_id);
        $inventaris->delete();

        return response()->json([
            'status' => true,
            'data' => null,
            'message' => 'Inventaris deleted successfully',
        ], 200);
    }

    public function listInventaris()
    {
        $inventaris = Inventaris::all();

        if ($inventaris->isEmpty()) {
            return response()->json([
                'status' => false,
                'message' => 'No items found in the inventaris',
            ], 200);
        }

        return response()->json([
            'status' => true,
            'data' => $inventaris,
            'message' => 'Inventaris listed successfully',
        ], 200);

    }

    public function inventarisById(Request $request, $id)
    {
        try {
            $inventaris = Inventaris::findOrFail($id);
        
            return response()->json([
                'status' => true,
                'data' => $inventaris,
                'message' => 'Inventaris listed successfully',
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Inventaris not found',
            ], 404);
        }
        
    }

}