<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class MedirMemoria extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'medir:memoria';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Mide la memoria usada en MB';

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
     * @return int
     */
    public function handle()
    {
            echo 'Memoria usada: ' . memory_get_peak_usage(true) / 1024 / 1024 . " MB\n";
            return 0;
    }
}
