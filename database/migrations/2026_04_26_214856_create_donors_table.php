<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('donors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('phone', 20);
            $table->enum('blood_type', ['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-']);
            $table->text('address');
            $table->string('city', 100);
            $table->date('date_of_birth');
            $table->enum('gender', ['male', 'female', 'other']);
            $table->decimal('weight', 5, 2);
            $table->text('medical_history')->nullable();
            $table->timestamp('last_donation_date')->nullable();
            $table->boolean('is_available')->default(true);
            $table->timestamps();
            
            // Indexes
            $table->index('blood_type');
            $table->index('city');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('donors');
    }
};