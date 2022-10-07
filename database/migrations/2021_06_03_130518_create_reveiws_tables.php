<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReveiwsTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('votes', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('kitchen_id')->constrained('kitchens');
            $table->foreignId('meal_id')->nullable()->constrained('meals');

            $table->unsignedFloat('rate')->default(0);
            $table->string('comment')->nullable();

            $table->timestamps();
        });
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();

            $table->foreignId('vote_id', )->constrained('votes');
            $table->foreignId('kitchen_id', )->constrained('kitchens');

            $table->unsignedFloat('rate', )->default(0);
            $table->unsignedInteger('reviewers', )->default(0);

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
        Schema::dropIfExists('votes');
        Schema::dropIfExists('reviews');
    }
}
