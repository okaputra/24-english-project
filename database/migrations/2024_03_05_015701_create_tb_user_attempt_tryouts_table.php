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
        Schema::create('tb_user_attempt_tryouts', function (Blueprint $table) {
            $table->id();
            $table->integer("id_user");
            $table->integer("id_tryout");
            $table->date("start");
            $table->date("end")->nullable();
            $table->integer("count_attempt")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_user_attempt_tryouts');
    }
};
