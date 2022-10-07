<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAddressIdToSpecialOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('special_orders', function (Blueprint $table) {
            $table->dropColumn('address');
            $table->foreignId('address_id')->nullable()->constrained('addresses')->nullOnDelete();
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
            $table->dropColumn('address_id');
        });
    }
}
