<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'user_id', 'total','description', 'status'
    ];

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function order_products()
    {
        return $this->hasMany('App\Models\OrderProduct');
    }
}
