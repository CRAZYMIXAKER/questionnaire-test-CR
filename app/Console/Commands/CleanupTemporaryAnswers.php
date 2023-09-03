<?php

namespace App\Console\Commands;

use App\Models\Answer;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CleanupTemporaryAnswers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cleanup:temporary-answers';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clean up temporary answers form the answers table weekly';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Answer::where('created_at', '<', Carbon::now()->subWeek())->delete();

        $this->info('Expired records cleaned up successfully.');
    }
}
