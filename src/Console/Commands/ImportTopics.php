<?php

namespace Mindyourteam\Core\Console\Commands;

use Illuminate\Console\Command;

class ImportTopics extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import {--source= : Source directory}';
    protected $dir = Null;
    protected $data = [];

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import topics from a directory of topic files';

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
        $this->dir = $this->option('source');
        $this->info("Importing {$this->dir}...");

        if ($d = @opendir($this->dir)) {
            while (false !== ($entry = readdir($d))) {
                if (in_array($entry, ['.', '..'])) {
                    continue;
                }
                $dir = $this->dir . '/' . $entry;
                if (!is_dir($dir)) {
                    continue;
                }
                $dir_info = $dir . '/.index.yaml';
                

                $this->readTopics($dir);
            }

            closedir($d);
        }
        else {
            $this->error("Can't read {$this->dir}");
        }
    }
}
