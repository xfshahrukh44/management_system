<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductComment extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'user_id', 'product_id', 'content', 'is_approved', 'created_by', 'modified_by'
    ];

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function product()
    {
        return $this->belongsTo('App\Models\Product');
    }
}
