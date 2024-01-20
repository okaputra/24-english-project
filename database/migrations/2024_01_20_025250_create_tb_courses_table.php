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
        Schema::create('tb_courses', function (Blueprint $table) {
            $table->id();
            $table->string("course_name",100);
            $table->longText("description");
            $table->string('pricing');
            $table->string('components');
            $table->string("thumbnail");
            $table->integer("rating")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_courses');
    }
};
