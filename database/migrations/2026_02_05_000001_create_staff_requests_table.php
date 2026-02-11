<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('staff_requests', function (Blueprint $table) {
            $table->id();

            // Context
            $table->foreignId('school_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('requester_id')
                ->constrained('admins')
                ->cascadeOnDelete();

            // Step 1: Basic Information
            $table->string('name');
            $table->string('email')->unique();
            $table->string('mobile', 15)->nullable();
            $table->string('photo')->nullable();

            // Aadhaar Details
            $table->string('aadhaar_number')->nullable();
            $table->string('aadhaar_name')->nullable();
            $table->date('aadhaar_dob')->nullable();
            $table->enum('aadhaar_gender', ['male', 'female', 'other'])->nullable();

            $table->enum('staff_type', [
                'teacher',
                'admin_staff',
                'librarian',
                'lab_assistant'
            ]);

            // Step 2: Professional Details
            $table->json('professional_details')->nullable();

            // Step 3: Role & System Access
            $table->enum('role', [
                'staff',
                'sub_admin',
                'invigilator'
            ]);

            $table->string('password');

            $table->enum('login_method', ['password', 'otp'])->default('password');
            $table->boolean('two_factor')->default(true);

            // Request & Approval Logic
            $table->enum('status', [
                'pending_verification',
                'approved',
                'rejected'
            ])->default('pending_verification');

            $table->text('rejection_reason')->nullable();

            // Approval Audit
            $table->foreignId('approved_by')
                ->nullable()
                ->constrained('super_admins')
                ->nullOnDelete();

            $table->timestamp('approved_at')->nullable();

            $table->index('status');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('staff_requests');
    }
};
