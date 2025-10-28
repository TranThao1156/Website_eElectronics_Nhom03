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
        Schema::create('caidat', function (Blueprint $table) {
            $table->id();
            $table->string('TenWebsite')->default('eElectronics');
            $table->text('MoTa')->nullable();
            $table->string('Facebook')->nullable();
            $table->string('Twitter')->nullable();
            $table->string('Youtube')->nullable();
            $table->string('Linkedin')->nullable();
            $table->string('Pinterest')->nullable();
            $table->string('Copyright')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('caidat');
    }
};
