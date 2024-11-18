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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('secondary_category_id')->nullable()->constrained('secondary_categories', 'id' )->onUpdate('cascade')->onDelete('set null');
            $table->text('food_label');
            $table->string('product_name');
            $table->text('ingredient')->nullable();
            $table->decimal('amount', 10, 3)->nullable();
            $table->string('manufacture');
            $table->decimal('per_gram', 10, 3)->nullable();
            $table->decimal('calories', 10, 3)->nullable();
            $table->decimal('proteins', 10, 3)->nullable();
            $table->decimal('fat', 10, 3)->nullable();
            $table->decimal('carbohydrates', 10, 3)->nullable();
            $table->decimal('salt', 10, 3)->nullable();
            $table->text('other')->nullable();
            $table->text('remarks')->nullable();
            $table->foreignId('image_first')->nullable()->constrained('images')->onDelete('cascade');
            $table->foreignId('image_second')->nullable()->constrained('images')->onDelete('cascade');
            $table->foreignId('image_third')->nullable()->constrained('images')->onDelete('cascade');
            $table->foreignId('image_fourth')->nullable()->constrained('images')->onDelete('cascade');
            $table->boolean('publication_status');
            $table->timestamps();
            $table->softDeletes();
        });
    }
        
    /**
    * Reverse the migrations.
    */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};


