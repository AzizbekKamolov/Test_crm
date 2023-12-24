<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    use HasFactory;
    protected $table = 'materials';

    public function wareHouses()
    {
        return $this->hasMany(WareHouse::class, 'material_id', 'id');
    }
    public function productMaterials()
    {
        return $this->belongsToMany(Product::class, 'product_materials');
    }
}
