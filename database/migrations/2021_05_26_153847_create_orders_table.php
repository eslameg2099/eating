<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->onDelete('no action');

//            $table->foreignId('address_id')->nullable()->constrained()->cascadeOnDelete(); //TODO on adresses
            $table->string('address')->nullable();

            $table->decimal('total_cost', 10, 2)->default(1);
            $table->decimal('total_discount', 10, 2)->nullable();
//            $table->float('coupon_id'); //TODO: On Coupons

            $table->boolean('purchased')->nullable();
            $table->unsignedInteger('payment_method')->nullable();

            $table->decimal('shipping_cost')->default(0);
            $table->foreignId('delegate_id')->nullable()->constrained('users')->cascadeOnDelete();
            $table->unsignedInteger('status')->default(0);
            $table->text('notes')->nullable(); // TODO - Drop column

            $table->timestamp('cooked_at')->nullable();
            $table->timestamp('received_at')->nullable();
            $table->timestamp('delivered_at')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
