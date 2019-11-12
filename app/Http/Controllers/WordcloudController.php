<?php

namespace App\Http\Controllers;

use App\Wordcloud;
use App\Word;
use Illuminate\Http\Request;
use lotsofcode\TagCloud\TagCloud;

class WordcloudController extends Controller
{
    public function form(Wordcloud $wordcloud, Request $request)
    {
        $words = Word::where('user_id', $request->user()->id)
            ->where('wordcloud_id', $wordcloud->id)
            ->get();

        return view('wordcloud.form', [
            'user' => $request->user(),
            'wordcloud' => $wordcloud,
            'words' => $words,
        ]);
    }

    public function contribute(Wordcloud $wordcloud, Request $request)
    {
        $user = $request->user();

        Word::where('user_id', $request->user()->id)
            ->where('wordcloud_id', $wordcloud->id)
            ->delete();

        foreach ($request->word as $word) {
            if ($word) {
                Word::create([
                    'wordcloud_id' => $wordcloud->id,
                    'user_id' => $user->id,
                    'word' => $word,
                ]);
            }
        }
        return redirect()->route('wordcloud.show', [
            'wordcloud' => $wordcloud
        ])
            ->with('status', 'Deine Eingaben wurden gespeichert.');
    }

    public function show(Wordcloud $wordcloud)
    {
        $cloud = new TagCloud();

        $cloud->setHtmlizeTagFunction(function($tag, $size) {
            $font_size = $size * 2 + 14;
            $title = preg_replace('/\s+/', '_', $tag['tag']) . '<sup>' . $tag['size'] . '</sup>';
            return "<span class='tag' style='font-size:{$font_size}px'>{$title}</span> ";
        });

        $words = $wordcloud->words->map(function($word) {
            return [
                'tag' => $word->word,
            ];
        })->toArray();
        $cloud->addTags($words);

        return view('wordcloud.show', [
            'wordcloud' => $wordcloud,
            'cloud' => $cloud
        ]);
    }
}
