<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            $table->string('label')->nullable();          // "Rumah", "Kantor"
            $table->string('recipient_name');             // nama penerima
            $table->string('phone')->nullable();

            $table->string('address_line1');              // jalan/RT/RW
            $table->string('address_line2')->nullable();  // komplek/apt
            $table->string('village')->nullable();        // kelurahan/desa
            $table->string('district')->nullable();       // kecamatan
            $table->string('city');                       // kota/kabupaten
            $table->string('province');                   // provinsi
            $table->string('postal_code', 10);

            $table->text('notes')->nullable();            // catatan kurir
            $table->boolean('is_default_shipping')->default(false);
            $table->boolean('is_default_billing')->default(false);

            $table->timestamps();

            // Index yang berguna
            $table->index(['user_id', 'is_default_shipping']);
            $table->index(['user_id', 'is_default_billing']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('addresses');
    }
};
