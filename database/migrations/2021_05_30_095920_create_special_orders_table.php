<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSpecialOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('special_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id', )->constrained('users')->cascadeOnDelete();
            $table->foreignId('kitchen_id', )->constrained('kitchens')->cascadeOnDelete();
            $table->string('information', );
            $table->string('address' );
            $table->unsignedTinyInteger('payment_method', );
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
        Schema::dropIfExists('special_orders');
    }
}
