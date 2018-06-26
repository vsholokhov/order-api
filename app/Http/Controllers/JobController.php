<?php
/**
 * Created by IntelliJ IDEA.
 * User: vitaliy
 * Date: 6/25/18
 * Time: 9:08 PM
 */

namespace App\Http\Controllers;


use App\Models\Jobs;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class JobController extends Controller
{

    public function showJob()
    {
        echo "Show next job";
    }

    public function getJob($id)
    {

    }

    public function postJob(Request $request, Response $response)
    {
        try {
            $input = $request->all();

            $job = new Jobs();
            $job->job_id = $input['job_id'];
            $job->user_id = $input['user_id'];
            $job->command = $input['command'];
            $job->save();

            echo $response->isSuccessful();
        } catch (\Exception $exception) {
            echo $exception->getMessage();
        }
    }

    public function deleteJob($id)
    {
        throw new \Exception("Sorry, you're not allowed to delete jobs");
    }
}