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
        Schema::create('favorites', function (Blueprint $table) {
            $table->string('favorite_id')->primary();
            $table->string('member_id');
            $table->timestamps();

            $table->foreign('member_id')
                ->references('member_id')
                ->on('members')
                ->onDelete('cascade');
            $table->index('member_id');
        });

        Schema::create('favorite_entries', function (Blueprint $table) {
            $table->string('entry_id')->primary();
            $table->string('favorite_id');
            $table->string('target_type', 50);
            $table->string('target_id');
            $table->timestamps();

            $table->foreign('favorite_id')
                ->references('favorite_id')
                ->on('favorites')
                ->onDelete('cascade');
            $table->index('favorite_id');
            $table->index(['target_type', 'target_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('favorite_entries');
        Schema::dropIfExists('favorites');
    }
};

