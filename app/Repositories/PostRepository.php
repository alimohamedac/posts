<?php

namespace App\Repositories;

use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class PostRepository
{
    public function all()
    {
        return Auth::user()->posts()->with('tags')
            ->orderByDesc('pinned')
            ->get();
    }

    public function find($id)
    {
        return Post::findOrFail($id);
    }

    public function create(array $data)
    {
        return Auth::user()->posts()->create($data);
    }

    public function update(Post $post, array $data)
    {
        $post->update($data);

        return $post;
    }

    public function delete(Post $post)
    {
        $post->delete();

        return $post;
    }

    public function trashed()
    {
        return Auth::user()->posts()->onlyTrashed()->get();
    }

    public function restore($id)
    {
        $post = Auth::user()->posts()->onlyTrashed()->findOrFail($id);
        $post->restore();

        return $post;
    }
}
