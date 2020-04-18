<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('blueprint_id');
            $table->foreign('blueprint_id')->references('id')->on('blueprints');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->enum('lang', ['de', 'en']);
            $table->enum('type', ['yesno', '1to5', '1to10', 'text']);
            $table->string('min');
            $table->string('max');
            $table->text('body');
            $table->datetime('planned_at');
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
        Schema::dropIfExists('culture_questions');
    }
}
