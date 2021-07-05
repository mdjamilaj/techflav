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
        //additional
        $this->addMediaCollection("product-gallery");
        $this->addMediaCollection("product-download")->singleFile();
        $this->addMediaCollection("product-and-documentation-download")->singleFile();
        // ->useDisk('s3')
    }
}