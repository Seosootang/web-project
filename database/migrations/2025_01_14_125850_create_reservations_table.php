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
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->string('customer')->nullable()->default(null);
            $table->string('packagechoice')->nullable()->default(null);
            $table->string('date')->nullable()->default(null);
            $table->string('pickup')->nullable()->default(null);
            $table->string('email')->nullable()->default(null);
            $table->string('phonenumber')->nullable()->default(null);
            $table->string('status')->nullable()->default(null);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};