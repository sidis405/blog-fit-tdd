<?php

namespace Acme\Http\Controllers;

use Acme\Models\Post;
use Illuminate\Http\Request;
use App\Events\PostWasUpdated;
use Acme\Repositories\PostsRepo;
use Acme\Http\Requests\PostRequest;
use App\Http\Controllers\Controller;

class PostsController extends Controller
{
    protected $postsRepo;

    public function __construct(PostsRepo $postsRepo)
    {
        $this->middleware('auth')->only('create', 'store', 'edit', 'update');
        $this->postsRepo = $postsRepo;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $posts = $this->postsRepo->getAll();

        // if ($request->wantsJson() || $request->ajax()) {
        //     return $posts;
        // }

        return view('posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostRequest $request)
    {
        $post = $this->postsRepo->createPost($request->validated());

        return redirect()->route('posts.show', $post);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        return view('posts.show')->with([
            'post' => $this->postsRepo->show($post)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        //
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
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        //
    }
}
