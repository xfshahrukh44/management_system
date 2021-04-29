<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name', 'category_id', 'brand_id', 'unit_id', 'price', 'image', 'description',
    ];

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function category()
    {
        return $this->belongsTo('App\Models\Category');
    }

    public function brand()
    {
        return $this->belongsTo('App\Models\Brand');
    }

    public function unit()
    {
        return $this->belongsTo('App\Models\Unit');
    }

    public function product_images()
    {
        return $this->hasMany('App\Models\ProductImage');
    }

    public function product_comments()
    {
        return $this->hasMany('App\Models\ProductComment');
    }

    public function ratings()
    {
        return $this->hasMany('App\Models\rating');
    }
}
