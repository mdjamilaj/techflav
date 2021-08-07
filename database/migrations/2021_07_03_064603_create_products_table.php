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
            $table->text('name');
            $table->text('details');
            $table->bigInteger('cover_photo_id')->nullable();
            $table->bigInteger('product_id')->nullable();
            $table->bigInteger('product_and_documentation_id')->nullable();
            $table->text('licence_key');
            $table->enum('product_price_type', ['free', 'paid'])->default('free');
            $table->integer('price')->nullable();
            $table->integer('discount_price')->nullable();
            $table->boolean('is_discount_percentage');
            $table->integer('product_type_id')->notNullable();
            $table->integer('product_category_id')->notNullable();
            $table->integer('product_platform_id')->notNullable();
            $table->text('file_included')->nullable();
            $table->boolean('is_featured');
            $table->boolean('is_topsale');
            $table->timestamps();
            $table->softDeletes();
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
