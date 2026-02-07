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
         Schema::create('security_logs', function (\Illuminate\Database\Schema\Blueprint $table) {

            $table->id();

            $table->string('guard'); // superadmin / admin
            $table->unsignedBigInteger('user_id')->nullable();

            $table->string('event');
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();

            $table->string('description')->nullable();
            $table->json('payload')->nullable();

            $table->timestamps();

            $table->index(['guard', 'user_id']);
            $table->index('event');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('security_logs');
    }
};
