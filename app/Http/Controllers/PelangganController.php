<?php

namespace App\Http\Controllers;

use App\Models\PelangganModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;

class PelangganController extends Controller
{
    protected $PelangganModel;

    public function __construct()
    {
        $this->PelangganModel = new PelangganModel();
    }

    public function index()
    {
        $Pelanggan = Cache::get('Pelanggan');

        if (!$Pelanggan) {
            $Pelanggan = $this->PelangganModel->get_Pelanggan();

            if (count($Pelanggan) === 0) {
                return response()->json([], 204);
            }

            Cache::put('Pelanggan', $Pelanggan, 300);
        } else {
            return response()->json([
                'status' => 200,
                'message' => 'Data Pelanggan berhasil didapatkan',
                'data' => $Pelanggan
            ], 200)->header('Cache-Control', 'public, max-age=300');
        }
    }

    public function show($id)
    {
        $Pelanggan = $this->PelangganModel->find($id);

        if ($Pelanggan == null) {
            return response()->json([
                'code' => 404,
                'success' => false,
                'message' => 'Gagal mendapatkan data Pelanggan! Pelanggan tidak ditemukan',
                'data' => $Pelanggan
            ], 404);
        } else {
            return response()->json([
                'code' => 200,
                'success' => true,
                'message' => 'Berhasil mendapatkan data Pelanggan!',
                'data' => $Pelanggan
            ]);
        }
    }

    public function store(Request $request)
{
    $validator = Validator::make($request->all(), [
        'pelanggan_nama'    => 'required|string|max:150',
        'pelanggan_alamat'  => 'required|string|max:200',
        'pelanggan_notelp'  => 'required|string|max:13', 
        'pelanggan_email'   => 'required|email|max:100', 
    ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => 422,
                'message' => 'Validasi pada data Pelanggan gagal!',
                'errors'  => $validator->errors()
            ], 422);
        } else {
            $Pelanggan = $this->PelangganModel->create_Pelanggan($validator->validated());

            return response()->json([
                'status'  => 201,
                'message' => 'Data Pelanggan berhasil dibuat!',
                'data'    => $Pelanggan
            ], 201);
        }
    }

    public function update(Request $request, $id)
{
    $validator = Validator::make($request->all(), [
        'pelanggan_nama'    => 'required|string|max:150',
        'pelanggan_alamat'  => 'required|string|max:200',
        'pelanggan_notelp'  => 'required|string|max:13', 
        'pelanggan_email'   => 'required|email|max:100',
    ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => 422,
                'message' => 'Validasi pada data Pelanggan gagal!',
                'errors'  => $validator->errors()
            ], 422);
        } else {
            $Pelanggan = $this->PelangganModel->update_Pelanggan($validator->validated(), $id);

            return response()->json([
                'status'  => 200,
                'message' => 'Data Pelanggan berhasil diupdate!',
                'data'    => $Pelanggan
            ], 200);
        }
    }

    public function destroy($id)
    {
        $Pelanggan = $this->PelangganModel->delete_Pelanggan($id);

        return response()->json([
            'status'  => 200,
            'message' => 'Data Pelanggan berhasil dihapus!',
            'data'    => $Pelanggan
        ], 200);
    }
}
