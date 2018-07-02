<?php
/**
 * Created by IntelliJ IDEA.
 * User: vitaliy
 * Date: 7/1/18
 * Time: 9:06 PM
 */

namespace App\Console\Commands;


use App\Models\Jobs;
use Illuminate\Console\Command;

class JobProcessor extends Command
{
    protected $signature = "job:process";

    public function handle()
    {
        try {
            // start timer
            $start = microtime(true);
            // Get single job that hasn't started yet with highest priority
            $job = Jobs::where('status', '0')->orderBy('priority', 'desc')->first();

            // set status to running
            $job->status = 1;
            $job->save();

            // run the job
            $this->info('Job id ' . $job['jobs_id'] . ' with priority ' . $job['priority'] . ' is running');

            // Take 10 seconds to 'do' the job
            sleep(10);

            // set status to done
            $job->status = 2;
            $job->save();
            $this->info('Done processing');

            $end = microtime(true);

            // insert amount of time it took to process
            $processing_time = $end - $start;
            $job->proceessing_time = $processing_time;

        } catch (\Exception $exception) {
            $this->error($exception->getMessage());
        }
    }

}