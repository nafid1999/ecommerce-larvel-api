<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->integer("user_id");
            $table->string("first_name");
            $table->string("last_name");
            $table->string("city");
            $table->string("state");
            $table->string("zip_code");
            $table->string("email");
            $table->string("adress");
            $table->string("phone");
            $table->string("payment_id")->nullable();
            $table->string("payment_mode");
            $table->string("no_tracking");
            $table->tinyInteger('status')->default('0');

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
        Schema::dropIfExists('orders');
    }
}
