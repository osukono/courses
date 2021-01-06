<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Imtigger\LaravelJobStatus\JobStatus;

class JobController extends Controller
{
    /**
     * @param JobStatus $jobStatus
     * @return JsonResponse
     */
    public function status(JobStatus $jobStatus)
    {
        return response()->json([
            'displayName' => $jobStatus->type,
            'progressNow' => $jobStatus->progress_now,
            'progressMax' => $jobStatus->progress_max,
            'progress_percentage' => $jobStatus->progress_percentage,
            'output' => $jobStatus->output != null ? $jobStatus->output : [],
            'status' => $jobStatus->status
        ]);
    }
}
