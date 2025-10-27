<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');   // 出品者（users.id）
            $table->string('image_path');   // 商品画像
            $table->string('condition')->comment('new:良好, good:目立った傷や汚れなし, used:やや傷や汚れあり, bad:状態が悪い');   // 商品状態
            $table->string('name');   // 商品名
            $table->string('brand')->nullable();   // ブランド名
            $table->text('description');   // 商品説明
            $table->unsignedInteger('price'); // 価格
            $table->boolean('is_sold')->default(false);   // 売却フラグ
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
