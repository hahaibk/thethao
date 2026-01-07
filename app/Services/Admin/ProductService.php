<?php
namespace App\Services\Admin;

use App\Models\Product;

class ProductService
{
    public function create(array $data): Product
    {
        return Product::create([
            'category_id' => $data['category_id'],
            'name'        => $data['name'],
            'price'       => $data['price'],
            'variants'    => $data['variants'] ?? [],
        ]);
    }

    public function update(Product $product,array $data): Product
    {
        $product->update([
            'category_id'=>$data['category_id'],
            'name'=>$data['name'],
            'price'=>$data['price'],
        ]);
        return $product;
    }

    public function addStock(Product $product,array $variants): void
    {
        foreach($variants as $v){
            $product->increaseStock($v['size'] ?? null,$v['color'],$v['stock']);
        }
    }

    public function delete(Product $product): void
    {
        $product->delete();
    }
}
