<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Session;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * @param $job mixed
     * @param $redirect
     * @return RedirectResponse
     */
    public function dispatchJob($job, $redirect)
    {
        $this->dispatch($job);
        try {
            $jobStatusId = $job->getJobStatusId();
            Session::flash('job-id', $jobStatusId);
            Session::flash('job-redirect-url', $redirect);
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
