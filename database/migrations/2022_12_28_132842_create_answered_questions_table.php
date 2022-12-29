<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('answered_questions', function (Blueprint $table) {
            $table->primary(['user_id', 'question_id']);
            $table->foreignId('user_id')
                ->constrained()
                ->onDelete('CASCADE')
                ->onUpdate('CASCADE');
            $table->foreignId('question_id')
                ->constrained()
                ->onDelete('CASCADE')
                ->onUpdate('CASCADE');
            $table->foreignId('alternative_id')
                ->constrained()
                ->onDelete('CASCADE')
                ->onUpdate('CASCADE');
            $table->boolean('is_correct');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('answered_questions');
    }
};
