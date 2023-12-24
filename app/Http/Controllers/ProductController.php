<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductMaterial;
use App\Models\WareHouse;
use Illuminate\Http\Request;
use Ramsey\Collection\Collection;

class ProductController extends Controller
{
    public function getProducts()
    {
        //Ko'ylakdan qolgan mahsulotlar qoldig'ini collectga yi'gib boramiz
        $collect = collect();

        $products = Product::query()->with('productMaterials')->get();
        foreach ($products as $product) {
            // Ko'ylak
            if ($product->id == 1) {
                $prepareProduct['product_name'] = $product->name;
                $prepareProduct['product_qty'] = 30;
                foreach ($product->productMaterials as $productMaterial) {
                    $wareHouses = WareHouse::query()
                        ->where('material_id', $productMaterial->material_id)
                        ->with('material')->get();
                    $quantity = $productMaterial->quantity * 30;
                    foreach ($wareHouses as $wareHouse) {
                        if ($wareHouse->remainder - $quantity < 0) {
                            $response[] = $this->materialProducts($wareHouse, $wareHouse->remainder);
                            $quantity -= $wareHouse->remainder;
                            continue;
                        }
                        $response[] = $this->materialProducts($wareHouse, $quantity);
                        $prepareProduct['product_materials'] = $response;
                        $qoldiq = $wareHouse->remainder - $quantity;
                        $collect->add([
                            'id' => $wareHouse->id,
                            'material_id' => $wareHouse->material_id,
                            'qoldiq' => $qoldiq,
                            'warehouse_id' => $wareHouse->id,
                        ]);
                    }
                }
                unset($response);
                $result[] = $prepareProduct;
            }elseif ($product->id == 2){
                $prepareProduct['product_name'] = $product->name;
                $prepareProduct['product_qty'] = 20;
                foreach ($product->productMaterials as $productMaterial){
                    $quantity = $productMaterial->quantity * 20;
                    if ($ss = $collect->where('material_id', $productMaterial->material_id)->first()) {
                        $wareHouses = WareHouse::query()
                            ->where('material_id', $productMaterial->material_id)
                            ->where('id', '>=', $ss['warehouse_id'])
                            ->with('material')->get();
                    }else{
                        $wareHouses = WareHouse::query()
                            ->where('material_id', $productMaterial->material_id)
                            ->orderBy('material_id')
                            ->with('material')->get();
                    }
                    foreach ($wareHouses as $wareHouse) {
                        if (isset($ss['qoldiq'])){
                            if ($ss['qoldiq']- $quantity < 0){
                                $empty['warehouse_id'] = null;
                                $empty['material_name'] = $wareHouse->material->name;
                                $empty['qty'] = $quantity - $ss['qoldiq'];
                                $empty['price'] = null;

                                $response[] = $this->materialProducts($wareHouse, $ss['qoldiq']);
                                $quantity -= $wareHouse->remainder;
                                $material_id = $wareHouse->material_id;
                                continue;
                            }
                        }
                        if ($wareHouse->remainder - $quantity < 0) {
                            $response[] = $this->materialProducts($wareHouse, $quantity);
                            $quantity -= $wareHouse->remainder;
                            $material_id = $wareHouse->material_id;
                            continue;
                        }
                        if (isset($material_id) && $material_id != $wareHouse->material_id){
                            $response[] = $empty;
                        }
                        $response[] = $this->materialProducts($wareHouse, $quantity);
                        $prepareProduct['product_materials'] = $response;
                    }
                }
                $result[] = $prepareProduct;
            }
        }
        return response()->json([
            'result' => $result
        ]);
    }

    public function materialProducts($wareHouse = null, $quantity = null)
    {
        return [
            'warehouse_id' => $wareHouse->id,
            'material_name' => $wareHouse->material->name,
            'qty' => $quantity,
            'price' => $wareHouse->price,
        ];

    }
}

