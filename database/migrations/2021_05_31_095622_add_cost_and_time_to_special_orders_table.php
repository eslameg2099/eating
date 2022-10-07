<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCostAndTimeToSpecialOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('special_orders', function (Blueprint $table) {
            $table->float('cost')->nullable()->after('address');
            $table->timestamp('time')->nullable()->after('cost');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('special_orders', function (Blueprint $table) {
            $table->dropColumn('cost');
            $table->dropColumn('time');
        });
    }
}
