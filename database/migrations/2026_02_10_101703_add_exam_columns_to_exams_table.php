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
        Schema::table('exams', function (Blueprint $table) {
            $table->string('academic_session')->after('created_by');
            $table->string('exam_type')->after('academic_session');
            $table->integer('pass_marks')->nullable()->after('exam_type');
            $table->boolean('negative_marking')->default(0)->after('pass_marks');
            $table->decimal('negative_marks', 5, 2)->default(0)->after('negative_marking');
            $table->boolean('shuffle_questions')->default(1)->after('negative_marks');
            $table->boolean('shuffle_options')->default(1)->after('shuffle_questions');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('exams', function (Blueprint $table) {
            $table->dropColumn(['academic_session', 'exam_type', 'pass_marks', 'negative_marking', 'negative_marks', 'shuffle_questions', 'shuffle_options']);
        });
    }
};
