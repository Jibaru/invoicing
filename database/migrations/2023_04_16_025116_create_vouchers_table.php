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
        Schema::create(
            'vouchers',
            function (Blueprint $table) {
                $table->uuid('id')->primary();
                $table->string('type', '30');
                $table->json('content');
                $table->longText('xml_content');
                $table->timestamps();
            }
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vouchers');
    }
};
