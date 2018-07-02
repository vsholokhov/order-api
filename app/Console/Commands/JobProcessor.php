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
            $jobs = Jobs::where('status', '0')->orderBy('priority', 'desc')->get();
            foreach ($jobs as $current) {

                $job = Jobs::find($current->jobs_id);

                // set status to running
                $job->status = 1;
                $job->save();

                // run the job
                $this->info('Job id ' . $job['jobs_id'] . ' with priority ' . $job['priority'] . ' is running');

                sleep(10);

                $job->status = 2;
                $job->save();
            }

        } catch (\Exception $exception) {
            $this->error($exception->getMessage());
        }
    }

}