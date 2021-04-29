<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Rating;

class Rating extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'user_id', 'product_id', 'stars'
    ];

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($query) {
            // Delete old if any
            if($rating = Rating::where('user_id', $query['user_id'])->where('product_id', $query['product_id'])->first()){
                $rating->forceDelete();
            }
        });

        static::updating(function ($query) {
            
        });

        static::created(function ($query) {

        });   
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function product()
    {
        return $this->belongsTo('App\Models\Product');
    }
}
