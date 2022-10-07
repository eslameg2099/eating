<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSponsorDurationTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sponsor_duration_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sponsor_duration_id')->constrained('sponsor_durations')->onDelete('cascade');
            $table->string('locale')->index();
            $table->string('title');
            $table->string('currency');

            $table->unique(['sponsor_duration_id', 'locale']);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sponsor_duration_translations');
    }
}
