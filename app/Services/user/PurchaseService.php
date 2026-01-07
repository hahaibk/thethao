<?php
namespace App\Services\User;

use App\Models\Product;
use Exception;

class PurchaseService
{
    public function buy(Product $product,$size,$color,$qty): void
    {
        if(!$product->hasStock($size,$color,$qty)){
            throw new Exception('Sản phẩm đã hết hàng');
        }
        $product->reduceStock($size,$color,$qty);
    }
}

