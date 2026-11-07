<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('enrollments', function (Blueprint $table) {
            $table->unsignedTinyInteger('year_level')->nullable();
        });

        DB::table('enrollments')
            ->join('students', 'enrollments.student_id', '=', 'students.id')
            ->update(['enrollments.year_level' => DB::raw('students.year_level')]);

        Schema::table('enrollments', function (Blueprint $table) {
            $table->unsignedTinyInteger('year_level')->nullable(false)->change();
            $table->dropColumn('grade');
        });
    }

    public function down(): void
    {
        Schema::table('enrollments', function (Blueprint $table) {
            $table->string('grade')->nullable();
            $table->dropColumn('year_level');
        });
    }
};
