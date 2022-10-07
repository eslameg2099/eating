<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDeliveredAtToAssignOrders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('assign_orders', function (Blueprint $table) {
            $table->timestamp('delivered_at')->after('assigned_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('assign_orders', function (Blueprint $table) {
            $table->dropColumn('delivered_at');
        });
    }
}
