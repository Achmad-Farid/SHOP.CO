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
        Schema::create('product_variants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->string('sku', 80)->nullable()->unique();
            $table->unsignedSmallInteger('color_id')->nullable();
            $table->unsignedSmallInteger('size_id')->nullable();
            $table->unsignedInteger('price');
            $table->integer('stock')->default(0);
            $table->unsignedInteger('weight_gram')->nullable();
            $table->timestamps();

            $table->unique(['product_id','color_id','size_id']);
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_variants');
    }
};
