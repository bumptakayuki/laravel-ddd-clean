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
        Schema::create('option_selections', function (Blueprint $table) {
            $table->string('selection_id')->primary();
            $table->string('configuration_id');
            $table->string('option_id');
            $table->integer('quantity')->default(1);
            $table->timestamps();

            $table->foreign('configuration_id')
                ->references('configuration_id')
                ->on('box_lunch_configurations')
                ->onDelete('cascade');
            $table->foreign('option_id')
                ->references('option_id')
                ->on('box_lunch_options')
                ->onDelete('cascade');
            $table->index('configuration_id');
            $table->index('option_id');
            $table->unique(['configuration_id', 'option_id']);
        });

        Schema::create('store_box_lunches', function (Blueprint $table) {
            $table->string('store_id');
            $table->string('box_lunch_id');
            $table->boolean('is_available')->default(true);
            $table->timestamps();

            $table->primary(['store_id', 'box_lunch_id']);
            $table->foreign('store_id')
                ->references('store_id')
                ->on('stores')
                ->onDelete('cascade');
            $table->foreign('box_lunch_id')
                ->references('box_lunch_id')
                ->on('box_lunches')
                ->onDelete('cascade');
            $table->index('is_available');
        });

        Schema::create('store_areas', function (Blueprint $table) {
            $table->string('store_id');
            $table->string('area_id');
            $table->boolean('is_deliverable')->default(true);
            $table->timestamps();

            $table->primary(['store_id', 'area_id']);
            $table->foreign('store_id')
                ->references('store_id')
                ->on('stores')
                ->onDelete('cascade');
            $table->foreign('area_id')
                ->references('area_id')
                ->on('areas')
                ->onDelete('cascade');
            $table->index('is_deliverable');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('store_areas');
        Schema::dropIfExists('store_box_lunches');
        Schema::dropIfExists('option_selections');
    }
};


