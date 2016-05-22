<?php

namespace App\Http\Controllers;

use Acme\Transformers\TagTransformer;
use App\Tag;
use App\Task;
use Illuminate\Http\Request;
use Illuminate\Http\Response as IlluminateResponse;
use Illuminate\Support\Facades\Input;

/**
 * Class TagController
 * @package App\Http\Controllers
 */
class TagController extends ApiController
{

    /**
     *
     * @var TagTransformer
     */
    protected $tagTransformer;

    /**
     * TagController constructor.
     * @param $tagTransformer
     */
    public function __construct(TagTransformer $tagTransformer)
    {
        $this->tagTransformer = $tagTransformer;
        //$this->middleware('auth.basic', ['only' => 'store']);
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     * @param null $taskId
     * @return \Illuminate\Http\Response
     */
    public function index($taskId = null)
    {
        $tag = $this->getTags($taskId);
        return $this->respond($this->tagTransformer->transformCollection($tag->all()));
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
        if (!Input::get('title'))
        {
            return $this->setStatusCode(IlluminateResponse::HTTP_UNPROCESSABLE_ENTITY)
                ->respondWithError('Parameters failed validation for a task.');
        }
        Tag::create(Input::all());
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
        $tag = Tag::find($id);
        if (!$tag) {
            return $this->respondNotFound('Tag does not exsist');
        }
        return $this->respond([
            'data' => $this->tagTransformer->transform($tag)
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
        $tag = Tag::find($id);
        if (!$tag)
        {
            return $this->respondNotFound('Tag does not exist!');
        }
        $tag->title = $request->title;
        $tag->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Tag::destroy($id);
    }

    /**
     * @param $taskId
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getTags($taskId)
    {
        return $taskId ? Task::findOrFail($taskId)->tags : Tag::all();
    }
}