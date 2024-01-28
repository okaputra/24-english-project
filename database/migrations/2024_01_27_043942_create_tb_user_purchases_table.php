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
        Schema::create('tb_user_purchases', function (Blueprint $table) {
            $table->id();
            $table->integer("id_user");
            $table->boolean("is_sudah_bayar");
            $table->integer("id_sub_terbayar");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_user_purchases');
    }
};
