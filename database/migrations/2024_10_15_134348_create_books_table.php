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
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->uuid('book_id')->unique();
            $table->uuid('rack_id');
            $table->uuid('category_id');
            $table->string('title');
            $table->string('isbn')->unique();
            $table->string('writer');
            $table->string('publisher');
            $table->year('publish_year');
            $table->string('cover')->nullable();
            $table->string('soft_file')->nullable();
            $table->integer('stock')->default(0);
            $table->timestamps();

            $table->foreign('rack_id')->references('rack_id')->on('racks')->onDelete('cascade');
            $table->foreign('category_id')->references('category_id')->on('categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
