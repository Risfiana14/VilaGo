<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('app_name')->default('VilaGo');
            $table->string('app_email')->default('admin@vilago.com');
            $table->string('app_phone')->default('081234567890');
            $table->text('app_address')->nullable();
            $table->decimal('service_fee', 8, 2)->default(0); // Biaya layanan / pajak (%)
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};