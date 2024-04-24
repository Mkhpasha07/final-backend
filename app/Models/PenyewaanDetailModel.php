<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriModel extends Model
{
    use HasFactory;

    protected $table = 'penyewaan_detail';
protected $primaryKey = 'penyewaan_detail_id';
protected $fillable = [
'penyewaan_detail_penyewaan_id',
'penyewaan_detail_alat_id',
'penyewaan_detail_jumlah',
'penyewaan_detail_subharga',
];

public function get_penyewaandetail()
    {
        return self::all();
    }

    public function create_penyewaandetail($data)
    {
        return self::create($data);
    }

    public function update_penyewaandetail($data, $id)
    {
        $PenyewaanDetail = self::find($id);
        $PenyewaanDetail->fill($data);
        $PenyewaanDetail->update();
        return $PenyewaanDetail;
    }

    public function delete_penyewaandetail($id)
    {
        $PenyewaanDetail = self::find($id);
        self::destroy($id);
        return $PenyewaanDetail;
    }
}
