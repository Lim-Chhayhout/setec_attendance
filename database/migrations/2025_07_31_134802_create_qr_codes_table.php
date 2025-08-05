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
        Schema::create('qr_codes', function (Blueprint $table) {
            $table->id();
            $table->string('qr_token')->unique();
            $table->string('ip_address', 50);
            $table->foreignId('teacher_id')->constrained('teachers')->onDelete('cascade');
            $table->integer('duration_min');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('expired_at');
        });

        Schema::create('qr_code_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('qr_id')->constrained('qr_codes')->onDelete('cascade');
            $table->string('subject', 100);
            $table->string('group', 100);
            $table->string('room', 100);
            $table->string('study_time', 100);
            $table->text('note')->nullable();
            $table->timestamps();
        });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('qr_codes');
        Schema::dropIfExists('qr_code_details');
    }
};
