<?php

namespace App\Http\Controllers;

use App\Http\Requests\Jobs\DeleteRequest;
use App\Http\Requests\Jobs\IndexRequest;
use App\Http\Requests\Jobs\ShowRequest;
use App\Http\Requests\Jobs\StoreRequest;
use App\Http\Requests\Jobs\UpdateRequest;
use App\Models\Job;
use Illuminate\Http\Response;

class JobsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(IndexRequest $request)
    {
        $per_page = null;
        $page = 1;
        if (null !== $request->input('perPage')) {
            $per_page = $request->input('perPage');
        }
        if (null !== $request->input('currentPage')) {
            $page = $request->input('currentPage');
        }
        $query = Job::whereNotNull('id');
        $user = $request->user;
        if (!$user->is_manager) {
            $query->where('user_id', $user->id);
        }
        if ($per_page == null) {
            $jobs = $query->orderBy("created_at", 'desc')->get();
        } else {
            $jobsData = $query->orderBy("created_at", 'desc')->paginate((int) $per_page, ['*'], 'page', (int) $page);
            $data['perPage'] = $jobsData->perPage();
            $data['currentPage'] = $jobsData->currentPage();
            $data['lastPage'] = $jobsData->lastPage();
            $data['total'] = $jobsData->total();
            $jobs = $jobsData->items();
        }
        $data['status'] = 'success';
        $data['jobs'] = $jobs;
        return $this->response($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {
        $user = $request->user;
        $data['status'] = 'fail';
        $data['statusCode'] = Response::HTTP_BAD_REQUEST;
        $job = new Job();
        $job->title = $request->input('title');
        $job->description = $request->input('description');
        $job->user_id = $user->id;
        if ($job->save()) {
            $data['status'] = 'success';
            $data['job'] = $job;
            $data['statusCode'] = Response::HTTP_OK;
            //notify the manager every time a job is created. This notification should not block any HTTP request
        }
        return $this->response($data);
    }
    
    public function show(ShowRequest $request, $id)
    {
        $data['status'] = 'fail';
        $data['statusCode'] = Response::HTTP_BAD_REQUEST;
        $user = $request->user;
        $job = Job::find($id);
        if ($job) {
            if ($user->is_manager || $user->id == $job->user_id) {
                $data['status'] = 'success';
                $data['job'] = $job;
                $data['statusCode'] = Response::HTTP_OK;
            }
        }
        return $this->response($data);
    }

    public function update(UpdateRequest $request, $id)
    {
        $data['status'] = 'fail';
        $data['statusCode'] = Response::HTTP_BAD_REQUEST;
        $user = $request->user;
        $job = Job::find($id);
        if ($job) {
            if ($user->is_manager || $user->id == $job->user_id) {
                $job->title = $request->input('title');
                $job->description = $request->input('description');
                $job->user_id = $user->id;
                if ($job->save()) {
                    $data['status'] = 'success';
                    $data['job'] = $job;
                    $data['statusCode'] = Response::HTTP_OK;
                }
            }
        }
        return $this->response($data);
    }

    public function delete(DeleteRequest $request, $id)
    {
        $data['status'] = 'fail';
        $data['statusCode'] = Response::HTTP_BAD_REQUEST;
        $user = $request->user;
        $job = Job::find($id);
        if ($job) {
            if ($user->is_manager || $user->id == $job->user_id) {
                $job->delete();
                $data['status'] = 'success';
                $data['statusCode'] = Response::HTTP_OK;
            }
        }
        return $this->response($data);
    }
}
