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
        Schema::create('box_lunches', function (Blueprint $table) {
            $table->string('box_lunch_id')->primary();
            $table->string('name');
            $table->text('description')->nullable();
            $table->decimal('base_price', 10, 2);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();

            $table->index('is_active');
        });

        Schema::create('stores', function (Blueprint $table) {
            $table->string('store_id')->primary();
            $table->string('name');
            $table->string('address', 500);
            $table->boolean('is_open')->default(true);
            $table->timestamps();
            $table->softDeletes();

            $table->index('is_open');
        });

        Schema::create('areas', function (Blueprint $table) {
            $table->string('area_id')->primary();
            $table->string('name');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('areas');
        Schema::dropIfExists('stores');
        Schema::dropIfExists('box_lunches');
    }
};



