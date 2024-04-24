<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriModel extends Model
{
    use HasFactory;

    protected $table = 'kategori';
protected $primaryKey = 'kategori_id';
protected $fillable = [
'kategori_nama',
];

public function get_kategori()
    {
        return self::all();
    }

    public function create_katagori($data)
    {
        return self::create($data);
    }

    public function update_kategori($data, $id)
    {
        $kategori = self::find($id);
        $kategori->fill($data);
        $kategori->update();
        return $kategori;
    }

    public function delete_kategori($id)
    {
        $kategori = self::find($id);
        self::destroy($id);
        return $kategori;
    }
}
