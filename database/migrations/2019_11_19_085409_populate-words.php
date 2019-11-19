<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PopulateWords extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('words', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->unique();
            $table->unsignedBigInteger('wordcloud_id');
            $table->foreign('wordcloud_id')->references('id')->on('wordclouds');
            $table->timestamps();
        });
        
        Schema::create('user_word', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedBigInteger('word_id');
            $table->foreign('word_id')->references('id')->on('words');
            $table->timestamps();
        });

        $words = DB::table('words_tmp')->get();

        foreach ($words as $data) {
            DB::table('words')->updateOrInsert(
                ['name' => $data->word, 'wordcloud_id' => $data->wordcloud_id],
                ['created_at' => \Carbon\Carbon::now()]
            );

            $word = DB::table('words')
                ->where('name', $data->word)
                ->where('wordcloud_id', $data->wordcloud_id)
                ->first();

            DB::table('user_word')
                ->insert([
                    'word_id' => $word->id,
                    'user_id' => $data->user_id,
                    'created_at' => $data->created_at,
                ]);
        }

        Schema::drop('words_tmp');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('words', function (Blueprint $table) {
            //
        });
    }
}
