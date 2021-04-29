<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderProduct extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'order_id', 'product_id','quantity'
    ];

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function order()
    {
        return $this->belongsTo('App\Models\Order');
    }
}
