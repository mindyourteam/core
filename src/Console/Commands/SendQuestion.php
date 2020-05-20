<?php

namespace Mindyourteam\Core\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Mindyourteam\Core\Models\Team;

class SendQuestion extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sendquestion {team_id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'For a specific team, send their upcoming question';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $team_id = (int) $this->argument('team_id');
        $team = Team::find($team_id);

        $question = Question::where('user_id', $team->lead_id)
            ->where('category', 'culture')
            ->whereRaw('planned_at > NOW()')
            ->orderBy('planned_at', 'asc')
            ->first();

        $this->info("Sending \"{$question->body}\" to team {$team->name}");

        foreach ($team->users as $user) {
            if (!$user->active) {
                continue;
            }
            $info->info(" - {$user->email}");

            Mail::send('mindyourteam::email-question', [
                'user' => $user,
                'question' => $question,
            ], function ($m) use ($user) {
                $m->from('hello@' . env('MAIL_DOMAIN'), config('app.name'));
                $m->to($user->email)->subject(
                    '[Frage] ' . $question->body
                );
            });
    
        }
    }
}
