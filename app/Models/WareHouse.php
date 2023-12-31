<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WareHouse extends Model
{
    use HasFactory;
    protected $table = 'warehouses';

    public function material()
    {
        return $this->belongsTo(Material::class, 'material_id', 'id');
    }
}
