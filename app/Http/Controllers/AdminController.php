<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;
use App\Models\AdminModel;

class AdminController extends Controller
{
    protected $adminModel;

    public function __construct()
    {
        $this->adminModel = new AdminModel();
    }

    public function index()
    {
        $admin = Cache::get('admin');

        if (!$admin) {
            $admin = $this->adminModel->get_admin();

            if (count($admin) === 0) {
                return response()->json([], 204);
            }

            Cache::put('admin', $admin, 300);
        } else {
            return response()->json([
                'status' => 200,
                'message' => 'Data admin berhasil didapatkan',
                'data' => $admin
            ], 200)->header('Cache-Control', 'public, max-age=300');
        }
    }

    public function show($id)
    {
        $admin = $this->adminModel->find($id);

        if ($admin == null) {
            return response()->json([
                'code' => 404,
                'success' => false,
                'message' => 'Gagal mendapatkan data admin! Admin tidak ditemukan',
                'data' => $admin
            ], 404);
        } else {
            return response()->json([
                'code' => 200,
                'success' => true,
                'message' => 'Berhasil mendapatkan data admin!',
                'data' => $admin
            ]);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'admin_username'  => 'required|string|max:50',
            'admin_password'  => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => 422,
                'message' => 'Validasi pada data admin gagal!',
                'errors'  => $validator->errors()
            ], 422);
        } else {
            $admin = $this->adminModel->create_admin($validator->validated());

            return response()->json([
                'status'  => 201,
                'message' => 'Data admin berhasil dibuat!',
                'data'    => $admin
            ], 201);
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'admin_username'  => 'required|string|max:50',
            'admin_password'  => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => 422,
                'message' => 'Validasi pada data admin gagal!',
                'errors'  => $validator->errors()
            ], 422);
        } else {
            $admin = $this->adminModel->update_admin($validator->validated(), $id);

            return response()->json([
                'status'  => 200,
                'message' => 'Data admin berhasil diupdate!',
                'data'    => $admin
            ], 200);
        }
    }

    public function destroy($id)
    {
        $admin = $this->adminModel->delete_admin($id);

        return response()->json([
            'status'  => 200,
            'message' => 'Data admin berhasil dihapus!',
            'data'    => $admin
        ], 200);
    }
}
