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
        Schema::create('tb_tryouts', function (Blueprint $table) {
            $table->id();
            $table->integer("id_quiz");
            $table->integer("durasi");
            $table->integer("id_sub_course");
            $table->integer("id_paket");
            $table->integer("count_attempt")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_tryouts');
    }
};
