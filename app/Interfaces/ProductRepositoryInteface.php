<?php

namespace App\Interfaces;

interface ProductRepositoryInteface
{
    public function getAllProducts();

    public function getProductById($id);

    public function updateProduct(array $data, $id);

    public function deleteProduct($id);

    public function storeProduct(array $data);
}
