<?php

namespace App\Http\Controllers;

use App\Wordcloud;
use App\Word;
use App\UserWord;
use Illuminate\Http\Request;
use lotsofcode\TagCloud\TagCloud;
use Illuminate\Database\Eloquent\Builder;

class WordcloudController extends Controller
{
    public function form(Wordcloud $wordcloud, Request $request)
    {
        $words = Word::where('wordcloud_id', $wordcloud->id)
            ->whereHas('users', function (Builder $query) use ($request) {
                $query->where('users.id', $request->user()->id);
            })
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
        $words = collect($request->word)->unique();

        UserWord::whereHas('word', function (Builder $query) use ($wordcloud) {
            $query->where('wordcloud_id', $wordcloud->id);
        })
            ->where('user_id', $request->user()->id)
            ->delete();

        Word::where('wordcloud_id', $wordcloud->id)
            ->doesntHave('users')
            ->delete();

        foreach ($words as $name) {
            if ($name) {
                $word = Word::updateOrCreate([
                    'wordcloud_id' => $wordcloud->id,
                    'name' => $name,
                ]);
                UserWord::create([
                    'word_id' => $word->id,
                    'user_id' => $user->id,
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

        $words = UserWord::with('word')
            ->whereHas('word', function (Builder $query) use ($wordcloud) {
                $query->where('wordcloud_id', $wordcloud->id);
            })
            ->get()->map(function($user_word) {
                return [
                    'tag' => $user_word->word->name,
                ];
            })->toArray();
        $cloud->addTags($words);

        $sorted = Word::with('users')
            ->withCount('users')
            ->where('wordcloud_id', $wordcloud->id)
            ->orderBy('users_count', 'desc')
            ->orderBy('name', 'asc')
            ->get();

        return view('wordcloud.show', [
            'wordcloud' => $wordcloud,
            'cloud' => $cloud,
            'sorted' => $sorted,
        ]);
    }
}
