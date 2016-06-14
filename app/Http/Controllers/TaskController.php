<?php

namespace App\Http\Controllers;

use Acme\Transformers\TaskTransformer;
use App\Task;
use Illuminate\Http\Request;
use Illuminate\Http\Response as IlluminateResponse;
use Illuminate\Support\Facades\Input;

class TaskController extends ApiController
{
    protected $taskTransformer;

    /**
     * TaskController constructor.
     * @param $taskTransformer
     */
    public function __construct(TaskTransformer $taskTransformer)
    {
        $this->taskTransformer = $taskTransformer;
        //$this->middleware('auth.basic', ['only' => 'store']);
        //$this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //1. No és retorna: paginació
        //return Task::all();
        $task = Task::all();
        return $this->respond($this->taskTransformer->transformCollection($task->all()));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *  @return \Illuminate\Http\Response
     */
    public function store()
    {
        if (!Input::get('name') or !Input::get('done') or !Input::get('priority'))
        {
            return $this->setStatusCode(IlluminateResponse::HTTP_UNPROCESSABLE_ENTITY)
                ->respondWithError('Parameters failed validation for a task.');
        }
        Task::create(Input::all());
        return $this->respondCreated('Task successfully created.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $task = Task::find($id);
        if (!$task) {
            return $this->respondNotFound('Task does not exsist');
        }
        return $this->respond([
            'data' => $this->taskTransformer->transform($task)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $task = Task::find($id);
        if (!$task)
        {
            return $this->respondNotFound('Task does not exist!!');
        }
        $task->name = $request->name;
        $task->priority = $request->priority;
        $task->done = $request->done;
        $task->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Task::destroy($id);
    }
}