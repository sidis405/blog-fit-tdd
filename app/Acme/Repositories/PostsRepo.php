<?php

namespace Acme\Repositories;

use Acme\Models\Post;

class PostsRepo
{
    public function getAll()
    {
        return Post::latest()->get();
    }

    public function createPost(array $params)
    {
        return auth()->user()->posts()->create($params);
    }

    public function show(Post $post)
    {
        return $post->load('category', 'user', 'tags');
    }

    public function update(Post $post, array $params)
    {
        $post->update($params);

        return $post->fresh();
    }
}
