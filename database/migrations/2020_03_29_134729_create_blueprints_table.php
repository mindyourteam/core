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
            $table->unsignedBigInteger('original_blueprint_id')->nullable();
            $table->foreign('original_blueprint_id')->references('id')->on('blueprints');
            $table->enum('category', ['culture']);
            $table->enum('type', ['yesno', '1to5', '1to10', 'text']);
            $table->string('min')->nullable();
            $table->string('max')->nullable();
            $table->enum('lang', ['de', 'en'])->default('en');
            $table->string('epic');
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
