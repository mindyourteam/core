<?php

namespace Mindyourteam\Core\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\User;
use Mindyourteam\Core\Controllers\Auth\LoginController as AuthLoginController;
use Mindyourteam\Core\Jobs\SendLoginMail;

class LoginController extends AuthLoginController
{
    protected $redirectTo = '/home';

    public function login(Request $request)
    {
        $user = User::where('name', $request->name)->firstOrFail();
        $token = Str::random(60);
        $user->setRememberToken($token);
        $user->save();

        $url = route('withtoken', [
            'token' => $token
        ]);
        $this->dispatch(new SendLoginMail($user, $url));
        return redirect('/')
            ->with('status', 'Wir haben einen Anmelde-Link an deine EMail-Adresse geschickt.');

    }

    public function withToken(Request $request)
    {
        $user = User::where('remember_token', $request->token)->firstOrFail();
        Auth::login($user, true);
        return redirect($this->redirectTo)
            ->with('status', 'Willkommen!');
    }
}
