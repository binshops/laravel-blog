<?php

namespace HessamCMS\Laravel\Fulltext\Commands;

use Illuminate\Console\Command;
use HessamCMS\Laravel\Fulltext\Indexer;

class Index extends Command
{
    protected $signature = 'laravel-fulltext:all {model_class}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Build the searchindex';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $indexer = new Indexer();
        $indexer->indexAllByClass($this->argument('model_class'));
    }
}
