<?php

declare (strict_types = 1);

namespace Task\Tracker\Commands;

use Illuminate\Console\Command;

class TrackerCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tracker:info';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Shows the tracker package information';

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
        $this->line('Package created by Nkwati for kt.team');
    }
}
