<?php

namespace Mindyourteam\Core\Console\Commands;

use Illuminate\Console\Command;
use Mindyourteam\Core\Models\Blueprint;
use Mindyourteam\Core\Models\Question;
use Carbon\Carbon;

class ClientQuestions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'client:questions {user_id} {language}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'For a specific client, create their questions from blueprints';

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
        $user_id = $this->argument('user_id');
        $lang = $this->argument('language');
        $this->info("Creating questions from blueprints for user {$user_id}, language={$lang}");

        $blueprints = Blueprint::where('lang', $lang)->get();

        $planned_at = Carbon::parse('next wednesday');
        $planned_at->tz = 'Europe/Berlin';
        $planned_at->hour = 8;
        $planned_at->minute = 30;

        foreach ($blueprints as $bp) {
            $plan = $planned_at->toDateTimeString();
            $this->info(" - {$bp->body} - planned for {$plan}");
            $record = $bp->toArray();
            unset($record['topic']);
            unset($record['rationale']);
            $record += [
                'blueprint_id' => $bp->id,
                'user_id' => $user_id,
                'planned_at' => $plan,
            ];
            Question::create($record);
            $planned_at->addWeek();
        }
    }
}
