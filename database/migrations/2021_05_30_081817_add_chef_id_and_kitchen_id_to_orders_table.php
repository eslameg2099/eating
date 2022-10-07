<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddChefIdAndKitchenIdToOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->foreignId('chef_id')->nullable()->after('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('kitchen_id')->nullable()->after('chef_id')->constrained()->cascadeOnDelete();
            $table->foreignId('delivery_id')->nullable()->after('user_id')->constrained('users')->cascadeOnDelete();
            ;
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
            $table->dropConstrainedForeignId('delivery_id');
            $table->dropConstrainedForeignId('kitchen_id');
            $table->dropConstrainedForeignId('chef_id');
        });
    }
}
