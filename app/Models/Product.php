<?php
  
namespace App\Models;
  
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Product extends Model implements HasMedia
{
    use HasFactory, SoftDeletes, InteractsWithMedia;
  
    /**
     * The attributes that are mass assignable.
     *	
     * @var array
     */
    protected $guarded = [];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection("product-gallery");
        $this->addMediaCollection("product-download")->singleFile();
        $this->addMediaCollection("product-and-documentation-download")->singleFile();
        // ->useDisk('s3')
    }

    public function product_type()
    {
        return $this->belongsTo(ProductType::class, 'product_type_id', 'id');
    }

    public function product_category()
    {
        return $this->belongsTo(ProductCategory::class, 'product_category_id', 'id');
    }

    public function product_platform()
    {
        return $this->belongsTo(ProductPlatform::class, 'product_platform_id', 'id');
    }

    public function favourite()
    {
        return $this->belongsTo(ProductFavourite::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'product_id', 'id');
    }
}