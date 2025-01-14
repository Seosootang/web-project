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
        Schema::create('car_rents', function (Blueprint $table) {
            $table->id();
            $table->string('customer')->nullable()->default(null);
            $table->string('phonenumber')->nullable()->default(null);
            $table->string('carname')->nullable()->default(null);
            $table->string('longrent')->nullable()->default(null);
            $table->string('renttype')->nullable()->default(null);
            $table->string('rentdate')->nullable()->default(null);
            $table->string('finishedrent')->nullable()->default(null);
            $table->string('pickuptime')->nullable()->default(null);
            $table->string('pickuplocation')->nullable()->default(null);
            $table->string('email')->nullable()->default(null);
            $table->string('message')->nullable()->default(null);
            $table->string('status')->nullable()->default(null);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('car_rents');
    }
};