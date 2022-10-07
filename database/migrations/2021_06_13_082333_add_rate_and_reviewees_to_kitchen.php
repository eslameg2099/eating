<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRateAndRevieweesToKitchen extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('kitchens', function (Blueprint $table) {
            $table->unsignedFloat('rate')->after('cookable_type')->default(0);
            $table->unsignedInteger('reviewers')->after('rate')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('kitchens', function (Blueprint $table) {
            $table->dropColumn('rate');
            $table->dropColumn('reviewers');
        });
    }
}
