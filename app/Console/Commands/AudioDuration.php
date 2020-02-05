<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;

class AudioDuration extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'audio:length {audio}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Returns the length of an audio file in ms using SoX';

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
        $output = [];
        exec("sox https://yummy-lingo.s3.eu-central-1.amazonaws.com/6eAaxRZio6WU8ab1DhyrcdZ5RHdg7IB0eXuh0xBy.wav -n stat 2>&1 | sed -n 's#^Length (seconds):[^0-9]*\([0-9.]*\).*$#\1#p'", $output);

        return $output;
//        $process = new Process(['ls', '-lsa']);
//        $process->run();
//        $this->info($process->getOutput());
//        return exec("length-of-audio-file-in-ms.sh " . $this->argument('audio'));
//        return $process->getOutput();
    }
}
