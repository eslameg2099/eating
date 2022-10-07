<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPaymentTypeToKitchenSponsorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('kitchen_sponsor', function (Blueprint $table) {
            $table->tinyInteger("payment_type")->nullable()->after('sponsor_duration_id');
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
            $table->dropColumn("payment_type");
        });
    }
}
