<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EditsOnOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('total_discount');
            $table->float('discount_percentage')->default(0)->after('total_cost');
            $table->decimal('sub_total')->default(0)->after('address_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->decimal('total_discount', 10, 2)->nullable();
            $table->dropColumn('discount_percentage');
            $table->dropColumn('sub_total');
        });
    }
}
