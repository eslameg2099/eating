<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddKitchenDurationIdToKitchenSponsorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('kitchen_sponsor', function (Blueprint $table) {
            $table->foreignId('kitchen_duration_id')->after('id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('kitchen_sponsor', function (Blueprint $table) {
            $table->dropColumn('kitchen_duration_id');
        });
    }
}
