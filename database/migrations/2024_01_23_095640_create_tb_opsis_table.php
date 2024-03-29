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
        Schema::create('tb_opsis', function (Blueprint $table) {
            $table->id();
            $table->longText("opsi");
            $table->boolean("is_jawaban_benar");
            $table->integer("id_soal");
            $table->string("audio_file")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_opsis');
    }
};
