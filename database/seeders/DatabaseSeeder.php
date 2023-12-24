<?php

namespace Database\Seeders;

use App\Models\Material;
use App\Models\Product;
use App\Models\ProductMaterial;
use App\Models\WareHouse;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $materials = [
            [
                "name" => 'Mato',
            ],
            [
                "name" => 'Ip',
            ],
            [
                "name" => 'Tugma',
            ],
            [
                "name" => 'Zamok',
            ]
        ];
        $products = [
            [
                'name' => "Ko'ylak",
                'code' => rand(999, 9999)
            ],
            [
                'name' => "Shim",
                'code' => rand(999, 9999)
            ]
        ];
        $product_materials = [
            [
                "product_id" => 1,
                "material_id" => 1,
                "quantity" => 0.8,
            ],
            [
                "product_id" => 1,
                "material_id" => 3,
                "quantity" => 5,
            ],
            [
                "product_id" => 1,
                "material_id" => 2,
                "quantity" => 10,
            ],
            [
                "product_id" => 2,
                "material_id" => 1,
                "quantity" => 1.4,
            ],
            [
                "product_id" => 2,
                "material_id" => 2,
                "quantity" => 15,
            ],
            [
                "product_id" => 2,
                "material_id" => 4,
                "quantity" => 1,
            ],
        ];
        $wareHouses = [
            [
                "material_id" => 1,
                "remainder" => 12,
                "price" => 1500,
            ],
            [
                "material_id" => 1,
                "remainder" => 200,
                "price" => 1600,
            ],
            [
                "material_id" => 2,
                "remainder" => 40,
                "price" => 500,
            ],
            [
                "material_id" => 2,
                "remainder" => 300,
                "price" => 550,
            ],
            [
                "material_id" => 3,
                "remainder" => 500,
                "price" => 300,
            ],
            [
                "material_id" => 4,
                "remainder" => 1000,
                "price" => 2000,
            ]
        ];
        Product::query()->insert($products);
        Material::query()->insert($materials);
        ProductMaterial::query()->insert($product_materials);
        WareHouse::query()->insert($wareHouses);
    }
}
