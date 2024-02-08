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
        Schema::create('tb_quiz', function (Blueprint $table) {
            $table->id();
            $table->string("nama_quiz");
            $table->string("video_path");
            $table->string("video_thumbnail");
            $table->integer("durasi");
            $table->integer("id_sub_course");
            $table->integer("id_paket");
            $table->boolean("is_berbayar")->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_quiz');
    }
};
