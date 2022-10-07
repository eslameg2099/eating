<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
//        Schema::create('carts', function (Blueprint $table) {
//            $table->id();
//
//            $table->foreignId('user_id')->nullable()->constrained();
//            $table->foreignId('kitchen_id')->constrained();
//            $table->foreignId('meal_id')->constrained();
//
//            $table->unsignedTinyInteger('quantity')->default(1);
//            $table->decimal('cost', 10, 2);
//            $table->decimal('cost_after_discount', 10, 2)->nullable();
//
//            $table->uuid('identifier');
//            $table->boolean('purchased')->nullable();
//            $table->unsignedInteger('payment_method')->nullable();
//
//            $table->timestamps();
//        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
//        Schema::dropIfExists('carts');
    }
}
