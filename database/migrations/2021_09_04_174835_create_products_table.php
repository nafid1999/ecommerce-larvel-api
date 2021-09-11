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
            $table->integer("category_id");
            $table->string('name',191)->unique();
            $table->string('slug',191)->unique();
            $table->string('description',191)->nullable();
            $table->string('metaTitle',191)->nullable();
            $table->string('metaDesc',191)->nullable();
            $table->string('metaKeywords',191)->nullable();
            $table->string('image',191);
            $table->string('brand',191);
            $table->float('price',5);
            $table->float('o_price',5);
            $table->string('qte',191);
            $table->tinyInteger("status");
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
