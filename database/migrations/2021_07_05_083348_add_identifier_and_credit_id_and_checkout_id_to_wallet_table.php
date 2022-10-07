<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIdentifierAndCreditIdAndCheckoutIdToWalletTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('wallets', function (Blueprint $table) {
            $table->foreignId('credit_id')->nullable()->after('id')->onDelete('set null');
            $table->foreignId('checkout_id')->nullable()->after('credit_id')->onDelete('set null');
            $table->string('identifier')->nullable()->after('credit_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('wallets', function (Blueprint $table) {
            $table->dropColumn('identifier');
            $table->dropColumn('checkout_id');
            $table->dropColumn('credit_id');
        });
    }
}
