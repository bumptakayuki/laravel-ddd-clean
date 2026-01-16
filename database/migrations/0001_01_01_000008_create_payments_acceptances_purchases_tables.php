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
        Schema::create('payments', function (Blueprint $table) {
            $table->string('payment_id')->primary();
            $table->string('order_id');
            $table->string('method', 50);
            $table->string('status', 50);
            $table->string('transaction_id')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();

            $table->foreign('order_id')
                ->references('order_id')
                ->on('orders')
                ->onDelete('cascade');
            $table->index('order_id');
            $table->index('status');
            $table->index('transaction_id');
        });

        Schema::create('acceptances', function (Blueprint $table) {
            $table->string('acceptance_id')->primary();
            $table->string('order_id')->unique();
            $table->timestamp('accepted_at');
            $table->timestamps();

            $table->foreign('order_id')
                ->references('order_id')
                ->on('orders')
                ->onDelete('cascade');
        });

        Schema::create('purchases', function (Blueprint $table) {
            $table->string('purchase_id')->primary();
            $table->string('order_id')->unique();
            $table->timestamp('confirmed_at');
            $table->timestamps();

            $table->foreign('order_id')
                ->references('order_id')
                ->on('orders')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchases');
        Schema::dropIfExists('acceptances');
        Schema::dropIfExists('payments');
    }
};


