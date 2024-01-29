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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            // $table->unsignedBigInteger('category')->nullable();
            // $table->foreign('category')->references('id')->on('categories')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('category_id')->nullable()->constrained()->cascadeOnDelete();
            $table->text('title');
            $table->text('About');
            $table->text('description');
            $table->string('status')->default('draft');
            $table->string('rating')->nullable();
            $table->string('ratings_number')->nullable();
            $table->string('price');
            $table->string('discount')->nullable();
            $table->decimal('delivery_price', 8, 2)->default(0.00);
            $table->integer('quantity');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
