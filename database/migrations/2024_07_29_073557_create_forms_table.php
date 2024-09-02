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
        Schema::create('forms', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->unsignedBigInteger('template_id');
            $table->string('tautan')->nullable();
            $table->date('open');
            $table->date('close');
            $table->integer('tahun_ajaran');

            $table->unsignedBigInteger('user_id');
            $table->timestamps();

            $table->foreign('template_id')->references('id')->on('templates');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('forms');
    }
};
