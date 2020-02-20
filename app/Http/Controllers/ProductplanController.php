<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductplanController extends Controller
{
    public function publish(Request $request)
    {
        $source = intval($request->source);
        $target = intval($request->target);
        $result = shell_exec("cd \$HOME/work/cards; ./publish.sh {$source} {$target}");
        if ($result) {
            return back()->with('status', "Erfolgreich veröffentlicht: <pre>{$result}</pre>");
        }
        else {
            return back()->with('status', 'Es gab ein Problem');
        }
    }
}
