<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'user_id', 'post_id', 'content', 'is_approved', 'created_by', 'modified_by'
    ];

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($query) {
            $query->created_by = (auth()->user()) ? auth()->user()->id : NULL;
        });

        static::updating(function ($query) {
            $query->modified_by = (auth()->user()) ? auth()->user()->id : NULL;
        });
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function post()
    {
        return $this->belongsTo('App\Models\Post');
    }
}
