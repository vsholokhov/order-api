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

class JobController extends Controller
{

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function showJob()
    {
        try {
            $job = Jobs::where(['status' => 0])
                ->orderBy('priority', 'desc')
                ->get();

            return response()->json($job);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()]);
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getJob($id)
    {
        try {
            if ($job = Jobs::find($id)) {
                return response()->json($job);
            } else {
                return response()->json('job_not_found');
            }
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()]);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function postJob(Request $request)
    {
        try {
            $input = $request->all();

            $job = new Jobs();
            $job->user_id = $input['user_id'];
            $job->command = $input['command'];
            $job->save();

            return response()->json(['job_id' => $job->jobs_id]);
        } catch (\Exception $exception) {
            echo $exception->getMessage();
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateJob(Request $request)
    {
        try {
            $job = Jobs::find($request->get('job_id'));
            if (!empty($job)) {
                $job->command = $request->get('command');
                $job->priority = $request->get('priority');
                $job->save();

                return response()->json(['updated' => $job->jobs_id]);
            } else {
                return response()->json(['error' => 'could not update job']);
            }

        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()]);
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteJob($id)
    {
        return response()->json(['error' => "Sorry, you're not allowed to delete jobs"]);
    }
}