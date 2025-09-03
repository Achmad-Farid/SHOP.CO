<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('customer_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            $table->date('date_of_birth')->nullable();
            $table->enum('gender', ['male','female','other'])->nullable();
            $table->string('avatar_url')->nullable();
            $table->string('tax_number')->nullable();      // NPWP/opsional
            $table->boolean('marketing_opt_in')->default(false);

            $table->timestamps();

            // Performa saat load profil
            $table->unique('user_id'); // 1:1
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('customer_profiles');
    }
};
