<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // هاد الـ migration فاضي حيت appointment_time مش موجود
        // إذا بغيتي تزيدي appointment_time، استعملي هاد الكود:
        if (!Schema::hasColumn('appointments', 'appointment_time')) {
            Schema::table('appointments', function (Blueprint $table) {
                $table->time('appointment_time')->nullable();
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('appointments', 'appointment_time')) {
            Schema::table('appointments', function (Blueprint $table) {
                $table->dropColumn('appointment_time');
            });
        }
    }
};