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
        Schema::create('cost_center_budgets', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('period', 8);
            $table->string('currency');
            $table->decimal('amount', 14, 2);
            $table->uuid('cost_center_id');
            $table->foreign('cost_center_id')
                ->on('cost_centers')
                ->references('id')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cost_center_budgets');
    }
};
