<?php

namespace Acme\Http\Controllers\Api;

use Acme\Models\Post;
use Illuminate\Http\Request;
use App\Events\PostWasUpdated;
use Acme\Repositories\PostsRepo;
use Acme\Http\Requests\PostRequest;
use Acme\Http\Resources\PostsCollection;
use Acme\Http\Resources\Post as PostResource;

class PostsController extends ApiController
{
    protected $postsRepo;

    public function __construct(PostsRepo $postsRepo)
    {
        $this->postsRepo = $postsRepo;
        $this->middleware('jwt.auth')->only('store', 'update');
    }

    public function index(Request $request)
    {

        // $situazione  = new Situazione($req->param_a, $req->param_b);
        // $posts = $this->postsRepo->getAll()->map(function($post) use($situazione){
        //  aggiungia situazione a post->impostaSitauzione()
        // });


        // return new PostsCollection($this->postsRepo->getAll()); // effetivamente una risorsa
        // return new PostResource($this->postsRepo->show($post)); --> singola risorsa
        return PostResource::collection($this->postsRepo->getAll()); // --> collection di singole rirsose
    }

    /**
     * @SWG\Post(
     *   path="/posts",
     *   summary="Store a post",
     *   tags={"Posts"},
     *   operationId="storePost",
     *   consumes={"multipart/form-data"},
     *   produces={"application/json"},
     * @SWG\Parameter(
     *     name="title",
     *     in="formData",
     *     description="The post's title",
     *     required=true,
     *     type="string"
     *   ),
     * @SWG\Parameter(
     *     name="category_id",
     *     in="formData",
     *     description="The post's category_id",
     *     required=true,
     *     type="integer"
     *   ),
    *  security={{"default": {}}},
     * @SWG\Response(response=200, description="successful operation", @SWG\Schema(type="string")),
     * @SWG\Response(response=403, description="cannot authenticate"),
     * @SWG\Response(response=500, description="internal server error")
     * )
     */

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostRequest $request)
    {
        return $this->postsRepo->createPost($request->validated());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        // return $this->postsRepo->show($post);
        return new PostResource($this->postsRepo->show($post));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        $post = $this->postsRepo->update($post, [
            'title' => $request->title
        ]);

        event(new PostWasUpdated($post));

        return $post;
    }
}
