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
        Schema::create('supplier_items', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('reference');
            $table->string('code');
            $table->string('description');
            $table->decimal('quantity', 14, 3);
            $table->decimal('unit_price', 14, 3);
            $table->uuid('supplier_id');
            $table->foreign('supplier_id')
                ->on('suppliers')
                ->references('id')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('supplier_items');
    }
};
