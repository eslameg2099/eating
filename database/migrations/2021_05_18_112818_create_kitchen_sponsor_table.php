<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKitchenSponsorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kitchen_sponsor', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kitchen_id')->constrained()->onDelete(null);
            $table->foreignId('sponsor_duration_id')->constrained('sponsor_durations')->onDelete('cascade');
            $table->timestamp('start_date')->nullable();
            $table->boolean('paid')->default(0);
            $table->boolean('accepted')->default(0);
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
        Schema::dropIfExists('kitchen_sponsor');
    }
}
