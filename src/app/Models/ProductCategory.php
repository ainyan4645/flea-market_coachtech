<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    use HasFactory;

    // 中間テーブル名を明示
    protected $table = 'product_category';

    protected $fillable = [
        'product_id',
        'category_id',
    ];

    public $timestamps = true;
}
