<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('school_id');

            $table->string('class');    
            $table->string('subject');   

            $table->enum('type', ['mcq']);   
            $table->text('question_text');

            $table->integer('marks')->default(1);

            $table->enum('difficulty', ['easy', 'medium', 'hard'])->nullable();

            $table->unsignedBigInteger('created_by'); // admin id
            $table->enum('status', ['active', 'inactive'])->default('active');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};
