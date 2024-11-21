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
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('template_id'); // Foreign key for the form to which the question belongs
            $table->text('question'); // The question text
            $table->string('type'); // Type of the question (text, radio, dropdown, etc.)
            $table->json('options')->nullable(); // Options for questions like radio, checkbox, dropdown
            $table->boolean('required')->default(false); // Whether the question is required or not
            $table->integer('section')->default(1);
            $table->unsignedBigInteger('question_requirment')->nullable(); // ID of the question used as requirement
            $table->string('question_requirment_value')->nullable(); // Value for the requirement
            $table->string('question_requirment_text')->nullable(); // Value for the requirement
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('template_id')->references('id')->on('templates')->onDelete('cascade');
            // Foreign key constraint for question_requirment (references the same table)
            $table->foreign('question_requirment')->references('id')->on('questions')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};
