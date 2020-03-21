<?php

namespace Mindyourteam\Core\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendLoginMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $user;
    private $url;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($user, $url)
    {
        $this->user = $user;
        $this->url = $url;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $user = $this->user;
        $url = $this->url;
        Mail::send('mindyourteam::email-login', [
            'user' => $user,
            'url' => $url,
        ], function ($m) use ($user) {
            $m->from('hello@' . env('MAIL_DOMAIN'), config('app.name'));
            $m->to($user->email)->subject(
                'Anmeldelink für ' . config('app.name')
            );
        });
    }
}
