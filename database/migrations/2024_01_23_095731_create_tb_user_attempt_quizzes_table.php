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
        Schema::create('tb_user_attempt_quizzes', function (Blueprint $table) {
            $table->id();
            $table->integer("id_user");
            $table->integer("id_quiz");
            $table->date("start");
            $table->date("end")->nullable();
            $table->boolean("is_complete")->default(0);//this is used to check whether the users answer is complete/all correct
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_user_attempt_quizzes');
    }
};
