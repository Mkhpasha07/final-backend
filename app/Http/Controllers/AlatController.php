<?php

namespace App\Http\Controllers;

use App\Models\AlatModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;

class AlatController extends Controller
{
    protected $alatModel;
    public function __construct()
    {
        $this->alatModel = new AlatModel();
    }

    public function index()
    {
        $alat = Cache::get('alat');

        if (!$alat) {
            $alat = $this->alatModel->get_alat();

            if (count($alat) === 0) {
                return response()->json([], 204);
            }

            Cache::put('alat', $alat, 300);
        } else {
            return response()->json([
                'status' => 200,
                'message' => 'Data alat berhasil didapatkan',
                'data' => $alat
            ], 200)->header('Cache-Control', 'public, max-age=300');
        }
    }

    public function show($id)
    {
        $alat = AlatModel::find($id);

        if ($alat == null) {
            return response()->json([
                'code' => 404,
                'success' => false,
                'message' => 'Gagal mendapatkan data alat! alat tidak ditemukan',
                'data' => $alat
            ], 404);
        } else {
            return response()->json([
                'code' => 200,
                'success' => true,
                'message' => 'Berhasil mendapatkan data alat!',
                'data' => $alat
            ]);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'alat_name'  => 'required|string|max:150', // Perbaikan nama kolom menjadi 'alat_name'
            'alat_deskripsi'  => 'required|string|max:255',
            'alat_harga_sewa_perhari' => 'required|numeric',
            'alat_stok' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => 422,
                'message' => 'Validasi pada data alat gagal!',
                'errors'  => $validator->errors()
            ], 422);
        } else {
            $alat = $this->alatModel->create_alat($validator->validated());

            return response()->json([
                'status'  => 201,
                'message' => 'Data alat berhasil dibuat!',
                'data'    => $alat
            ], 201);
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'alat_nama'  => 'required|string|max:150',
            'alat_deskripsi'  => 'required|string|max:255',
            'alat_harga_sewa_perhari' => 'required|numeric',
            'alat_stok' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => 422,
                'message' => 'Validasi pada data alat gagal!',
                'errors'  => $validator->errors()
            ], 422);
        } else {
            $alat = $this->alatModel->update_alat($validator->validated(), $id);

            return response()->json([
                'status'  => 200,
                'message' => 'Data alat berhasil diupdate!',
                'data'    => $alat
            ], 200);
        }
    }

    public function destroy($id)
    {
        $alat = $this->alatModel->delete_alat($id);

        return response()->json([
            'status'  => 200,
            'message' => 'Data alat berhasil dihapus!',
            'data'    => $alat
        ], 200);
    }
}
