<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->string('order_id')->primary();
            $table->string('member_id');
            $table->string('store_id');
            $table->string('status', 50);
            $table->decimal('total_amount', 10, 2);
            $table->timestamp('ordered_at');
            $table->timestamps();

            $table->foreign('member_id')
                ->references('member_id')
                ->on('members')
                ->onDelete('cascade');
            $table->foreign('store_id')
                ->references('store_id')
                ->on('stores')
                ->onDelete('cascade');
            $table->index('member_id');
            $table->index('store_id');
            $table->index('status');
            $table->index('ordered_at');
        });

        Schema::create('order_items', function (Blueprint $table) {
            $table->string('order_item_id')->primary();
            $table->string('order_id');
            $table->string('configuration_id');
            $table->decimal('unit_price', 10, 2);
            $table->integer('quantity');
            $table->decimal('line_amount', 10, 2);
            $table->timestamps();

            $table->foreign('order_id')
                ->references('order_id')
                ->on('orders')
                ->onDelete('cascade');
            $table->foreign('configuration_id')
                ->references('configuration_id')
                ->on('box_lunch_configurations')
                ->onDelete('cascade');
            $table->index('order_id');
            $table->index('configuration_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
        Schema::dropIfExists('orders');
    }
};


