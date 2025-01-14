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
        Schema::create('packages', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable()->default(null);
            $table->string('image1')->nullable()->default(null);
            $table->string('image2')->nullable()->default(null);
            $table->string('image3')->nullable()->default(null);
            $table->string('destination1')->nullable()->default(null);
            $table->string('destination2')->nullable()->default(null);
            $table->string('destination3')->nullable()->default(null);
            $table->string('destination4')->nullable()->default(null);
            $table->string('destination5')->nullable()->default(null);
            $table->string('destination6')->nullable()->default(null);
            $table->string('destination7')->nullable()->default(null);
            $table->string('destination8')->nullable()->default(null);
            $table->string('price')->nullable()->default(null);
            $table->string('content')->nullable()->default(null);
            $table->string('status')->nullable()->default(null);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('packages');
    }
};