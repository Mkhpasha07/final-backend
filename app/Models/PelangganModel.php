<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PelangganModel extends Model
{
    use HasFactory;

    protected $table = 'pelanggan';
protected $primaryKey = 'pelanggan_id';
protected $fillable = [
'pelanggan_nama',
'pelanggan_alamat',
'pelanggan_notelp',
'pelanggan_email',
];

public function get_pelanggan()
    {
        return self::all();
    }

    public function create_pelanggan($data)
    {
        return self::create($data);
    }

    public function update_pelanggan($data, $id)
    {
        $pelanggan = self::find($id);
        $pelanggan->fill($data);
        $pelanggan->update();
        return $pelanggan;
    }

    public function delete_pelanggan($id)
    {
        $pelanggan = self::find($id);
        self::destroy($id);
        return $pelanggan;
    }
}
