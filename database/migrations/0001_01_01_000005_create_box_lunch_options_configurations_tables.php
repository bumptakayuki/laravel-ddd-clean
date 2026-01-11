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
        Schema::create('box_lunch_options', function (Blueprint $table) {
            $table->string('option_id')->primary();
            $table->string('box_lunch_id');
            $table->string('name');
            $table->decimal('price_delta', 10, 2)->default(0);
            $table->boolean('is_required')->default(false);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('box_lunch_id')
                ->references('box_lunch_id')
                ->on('box_lunches')
                ->onDelete('cascade');
            $table->index('box_lunch_id');
        });

        Schema::create('box_lunch_configurations', function (Blueprint $table) {
            $table->string('configuration_id')->primary();
            $table->string('box_lunch_id');
            $table->string('availability_status', 50);
            $table->decimal('total_price', 10, 2);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('box_lunch_id')
                ->references('box_lunch_id')
                ->on('box_lunches')
                ->onDelete('cascade');
            $table->index('box_lunch_id');
            $table->index('availability_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('box_lunch_configurations');
        Schema::dropIfExists('box_lunch_options');
    }
};

