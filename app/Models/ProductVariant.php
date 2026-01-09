<?php

namespace App\Models;
use App\Models\VariantImage;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class ProductVariant extends Model
{
    protected $fillable = ['product_id','color','size','quantity','price'];

    public function product() {
        return $this->belongsTo(Product::class);
    }

    public function images() {
        return $this->hasMany(VariantImage::class, 'variant_id');
    }

    // =====================
    // LOGIC
    // =====================
    public function updateVariant(array $data){
        $this->update([
            'color' => $data['color'] ?? $this->color,
            'size' => $data['size'] ?? $this->size,
            'quantity' => $data['quantity'] ?? $this->quantity,
            'price' => $data['price'] ?? $this->price
        ]);

        if(!empty($data['images'])){
            // Xóa ảnh cũ nếu muốn
            foreach($this->images as $img){
                Storage::disk('public')->delete($img->image_path);
                $img->delete();
            }
            // Thêm ảnh mới
            foreach($data['images'] as $img){
                $this->addImage($img);
            }
        }

        return $this;
    }

    public function deleteVariant(){
        foreach($this->images as $img){
            Storage::disk('public')->delete($img->image_path);
            $img->delete();
        }
        $this->delete();
    }

    public function addImage($file){
        $path = $file->store('products','public');
        return $this->images()->create(['image_path'=>$path]);
    }
}
