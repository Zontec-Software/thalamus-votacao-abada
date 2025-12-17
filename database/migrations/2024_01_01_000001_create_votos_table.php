<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('votos', function (Blueprint $table) {
            $table->id();
            $table->integer('pessoa_id');
            $table->string('nome_completo');
            $table->string('mac_address');
            $table->timestamps();

            $table->index('mac_address');
            $table->index('pessoa_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('votos');
    }
};

