<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PelangganDataModel extends Model
{
    use HasFactory;

    protected $table = 'Pelanggan_Data';
    protected $primaryKey = 'pelanggan_data_id';
    protected $fillable = [
        'pelanggan_data_pelanggan_id',
        'pelanggan_data_jenis',
        'pelanggan_data_file',
    ];

    public function get_PelangganData()
    {
        return self::all();
    }

    public function create_PelangganData($data)
    {
        return self::create($data);
    }

    public function update_PelangganData($data, $id)
    {
        $PelangganData = self::find($id);
        $PelangganData->fill($data);
        $PelangganData->update();
        return $PelangganData;
    }

    public function delete_PelangganData($id)
    {
        $PelangganData = self::find($id);
        self::destroy($id);
        return $PelangganData;
    }
}
