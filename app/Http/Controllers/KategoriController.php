<?php

namespace App\Http\Controllers;

use App\Models\KategoriModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;

class KategoriController extends Controller
{
    protected $kategoriModel;
    public function __construct()
    {
        $this->kategoriModel = new KategoriModel();
    }

    public function index()
    {
        $kategori = Cache::get('kategori');

        if (!$kategori) {
            $kategori = $this->kategoriModel->get_kategori();

            if (count($kategori) === 0) {
                return response()->json([], 204);
            }

            Cache::put('kategori', $kategori, 300);
        } else {
            return response()->json([
                'status' => 200,
                'message' => 'Data kategori berhasil didapatkan',
                'data' => $kategori
            ], 200)->header('Cache-Control', 'public, max-age=300');
        }
    }

    public function show($id)
    {
        $kategori = KategoriModel::find($id);

        if ($kategori == null) {
            return response()->json([
                'code' => 404,
                'success' => false,
                'message' => 'Gagal mendapatkan data kategori! kategori tidak ditemukan',
                'data' => $kategori
            ], 404);
        } else {
            return response()->json([
                'code' => 200,
                'success' => true,
                'message' => 'Berhasil mendapatkan data kategori!',
                'data' => $kategori
            ]);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'kategori_nama'  => 'required|string|max:100',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => 422,
                'message' => 'Validasi pada data kategori gagal!',
                'errors'  => $validator->errors()
            ], 422);
        } else {
            $kategori = $this->kategoriModel->create_katagori($validator->validated());

            return response()->json([
                'status'  => 201,
                'message' => 'Data kategori berhasil dibuat!',
                'data'    => $kategori
            ], 201);
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'kategori_nama'  => 'required|string|max:100',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => 422,
                'message' => 'Validasi pada data kategori gagal!',
                'errors'  => $validator->errors()
            ], 422);
        } else {
            $kategori = $this->kategoriModel->update_kategori($validator->validated(), $id);

            return response()->json([
                'status'  => 200,
                'message' => 'Data kategori berhasil diupdate!',
                'data'    => $kategori
            ], 200);
        }
    }

    public function destroy($id)
    {
        $kategori = $this->kategoriModel->delete_kategori($id);

        return response()->json([
            'status'  => 200,
            'message' => 'Data kategori berhasil dihapus!',
            'data'    => $kategori
        ], 200);
    }
}
