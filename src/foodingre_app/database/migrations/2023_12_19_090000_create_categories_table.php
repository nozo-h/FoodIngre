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
        Schema::create('primary_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('sort_no');
            $table->timestamps();
        });

        Schema::create('secondary_categories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('primary_category_id')->constrained()->onUpdate('cascade')->onDelete('restrict');
            $table->integer('secondary_id');
            $table->string('name');
            $table->integer('sort_no');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */

    // secondaryから削除する
    public function down(): void
    {
        Schema::dropIfExists('secondary_categories');
        Schema::dropIfExists('primary_categories');
    }
};
