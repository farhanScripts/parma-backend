<?php

namespace App\Repositories;

use App\Models\Product;
use App\Interfaces\ProductRepositoryInteface;

class ProductRepository implements ProductRepositoryInteface
{
    public function getAllProducts(){
        return Product::all();
    }

    public function getProductById($id) {
        return Product::findOrFail($id);
    }

    public function deleteProduct($id){
        Product::destroy($id);
    }

    public function storeProduct(array $data) {
        return Product::create($data);
    }

    public function updateProduct(array $data, $id) {
        return Product::find($id)->update($data);
    }
}
