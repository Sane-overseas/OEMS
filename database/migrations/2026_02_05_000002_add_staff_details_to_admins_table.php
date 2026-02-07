<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('admins', function (Blueprint $table) {
            // Add columns to store approved staff details
            $table->string('photo')->nullable()->after('mobile');
            $table->string('staff_type')->nullable()->after('role');
            $table->json('professional_details')->nullable()->after('staff_type');
        });
    }

    public function down(): void
    {
        Schema::table('admins', function (Blueprint $table) {
            $table->dropColumn(['photo', 'staff_type', 'professional_details']);
        });
    }
};