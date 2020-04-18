<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlueprintsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blueprints', function (Blueprint $table) {
            $table->id();
            $table->enum('category', ['culture']);
            $table->enum('type', ['yesno', '1to5', '1to10', 'text']);
            $table->string('min');
            $table->string('max');
            $table->enum('lang', ['de', 'en']);
            $table->string('topic');
            $table->text('body');
            $table->text('rationale');
            $table->string('source');
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
        Schema::dropIfExists('question_blueprints');
    }
}
