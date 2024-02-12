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
        Schema::create('tb_sub_courses', function (Blueprint $table) {
            $table->id();
            $table->string("sub_course", 100);
            $table->integer("id_course");
            $table->boolean("is_berbayar")->default(1);
            $table->string('pricing')->nullable();
            $table->integer("number_of_review")->nullable();
            $table->integer("rating")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_sub_courses');
    }
};
