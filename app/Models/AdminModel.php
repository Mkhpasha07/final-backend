<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminModel extends Model
{

    public $timestamps = false;
    use HasFactory;

    protected $table = 'admin';
    protected $primaryKey = 'admin_id';
    protected $fillable = [
        'admin_username',
        'admin_password',

    ];

    public function get_admin()
    {
        return self::all();
    }

    public function create_admin($data)
    {
        return self::create($data);
    }

    public function update_admin($data, $id)
    {
        $admin = self::find($id);
        $admin->fill($data);
        $admin->save();
        return $admin;
    }

    public function delete_admin($id)
    {
        $admin = self::find($id);
        self::destroy($id);
        return $admin;
    }
}
