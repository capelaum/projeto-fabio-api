<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('discipline_id')
                ->default(1)
                ->nullable()
                ->constrained()
                ->onUpdate('CASCADE')
                ->onDelete('SET NULL');
            $table->foreignId('category_id')
                ->default(1)
                ->nullable()
                ->constrained()
                ->onUpdate('CASCADE')
                ->onDelete('SET NULL');
            $table->string('title');
            $table->text('content');
            $table->integer('year');
            $table->boolean('is_active')->default(false);
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
        Schema::dropIfExists('questions');
    }
};
