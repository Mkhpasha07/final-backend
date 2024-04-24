<?php

namespace App\Http\Controllers;

use App\Models\PelangganDataModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;

class Pelanggan_DataController extends Controller
{
    protected $Pelanggan_DataModel;

    public function __construct()
    {
        $this->Pelanggan_DataModel = new PelangganDataModel();
    }

    public function index()
    {
        $Pelanggan_Data = Cache::get('Pelanggan_Data');

        if (!$Pelanggan_Data) {
            $Pelanggan_Data = $this->Pelanggan_DataModel->get_PelangganData();

            if (count($Pelanggan_Data) === 0) {
                return response()->json([], 204);
            }

            Cache::put('Pelanggan_Data', $Pelanggan_Data, 300);
        } else {
            return response()->json([
                'status' => 200,
                'message' => 'Data Pelanggan_Data berhasil didapatkan',
                'data' => $Pelanggan_Data
            ], 200)->header('Cache-Control', 'public, max-age=300');
        }
    }

    public function show($id)
    {
        $Pelanggan_Data = $this->Pelanggan_DataModel->find($id);

        if ($Pelanggan_Data == null) {
            return response()->json([
                'code' => 404,
                'success' => false,
                'message' => 'Gagal mendapatkan data Pelanggan_Data! Pelanggan_Data tidak ditemukan',
                'data' => $Pelanggan_Data
            ], 404);
        } else {
            return response()->json([
                'code' => 200,
                'success' => true,
                'message' => 'Berhasil mendapatkan data Pelanggan_Data!',
                'data' => $Pelanggan_Data
            ]);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'pelanggan_data_pelanggan_id' => 'required|integer',
            'pelanggan_data_jenis' => 'required|string', // Ganti dengan aturan validasi yang sesuai
            'pelanggan_data_file' => 'required|mimes:jpeg,png,jpg|max:2048', // Ubah menjadi aturan validasi file yang sesuai
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'message' => 'Validasi pada data Pelanggan_Data gagal!',
                'errors' => $validator->errors()
            ], 422);
        } else {
            $Pelanggan_Data = $this->Pelanggan_DataModel->create_PelangganData($validator->validated());

            return response()->json([
                'status' => 201,
                'message' => 'Data Pelanggan_Data berhasil dibuat!',
                'data' => $Pelanggan_Data
            ], 201);
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'pelanggan_data_pelanggan_id' => 'required|integer',
            'pelanggan_data_jenis' => 'required|string', // Ganti dengan aturan validasi yang sesuai
            'pelanggan_data_file' => 'required|mimes:jpeg,png,jpg|max:2048', // Ubah menjadi aturan validasi file yang sesuai
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'message' => 'Validasi pada data Pelanggan_Data gagal!',
                'errors' => $validator->errors()
            ], 422);
        } else {
            $Pelanggan_Data = $this->Pelanggan_DataModel->update_PelangganData($validator->validated(), $id);

            return response()->json([
                'status' => 200,
                'message' => 'Data Pelanggan_Data berhasil diupdate!',
                'data' => $Pelanggan_Data
            ], 200);
        }
    }

    public function destroy($id)
    {
        $Pelanggan_Data = $this->Pelanggan_DataModel->delete_PelangganData($id);

        return response()->json([
            'status' => 200,
            'message' => 'Data Pelanggan_Data berhasil dihapus!',
            'data' => $Pelanggan_Data
        ], 200);
    }
}
