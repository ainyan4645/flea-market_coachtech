<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'image_path', 'condition', 'name', 'brand', 'description', 'price', 'is_sold'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'product_category');
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function order()
    {
        return $this->hasOne(Order::class);
    }

    // 画像URLを返すアクセサ
    public function getImageUrlAttribute()
    {
        if (!$this->image_path) {
            return null; // image_pathが空なら画像なし
        }

        // ストレージにある場合
        if (str_starts_with($this->image_path, 'public/')) {
            $storagePath = str_replace('public/', 'storage/', $this->image_path);
            if (file_exists(public_path($storagePath))) {
                return asset($storagePath);
            }
        }

        // public/img/products/ にある場合
        if (file_exists(public_path($this->image_path))) {
            return asset($this->image_path);
        }

        // どちらにもない場合はnull（＝画像なし）
        return null;
    }
}
