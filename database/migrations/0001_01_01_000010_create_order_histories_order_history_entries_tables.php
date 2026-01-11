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
        Schema::create('order_histories', function (Blueprint $table) {
            $table->string('history_id')->primary();
            $table->string('member_id');
            $table->timestamp('generated_at');
            $table->timestamps();

            $table->foreign('member_id')
                ->references('member_id')
                ->on('members')
                ->onDelete('cascade');
            $table->index('member_id');
            $table->index('generated_at');
        });

        Schema::create('order_history_entries', function (Blueprint $table) {
            $table->string('entry_id')->primary();
            $table->string('history_id');
            $table->string('order_id');
            $table->string('store_name');
            $table->decimal('total_amount', 10, 2);
            $table->string('status', 50);
            $table->timestamp('occurred_at');
            $table->timestamps();

            $table->foreign('history_id')
                ->references('history_id')
                ->on('order_histories')
                ->onDelete('cascade');
            $table->index('history_id');
            $table->index('order_id');
            $table->index('occurred_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_history_entries');
        Schema::dropIfExists('order_histories');
    }
};

