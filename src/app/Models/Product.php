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
            return null;
        }

        // image_path は "storage/products/seeding/..."
        return asset($this->image_path);
    }

    // 商品状態ラベルを返すアクセサ
    public function getConditionLabelAttribute()
    {
        return match ($this->condition) {
            'new' => '良好',
            'good' => '目立った傷や汚れなし',
            'used' => 'やや傷や汚れあり',
            'bad' => '状態が悪い',
            default => '未設定',
        };
    }

}
