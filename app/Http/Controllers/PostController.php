<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Repositories\PostRepository;
use App\Transformers\PostTransformer;
use App\Http\Requests\StorePostRequest;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    protected $postRepository;

    public function __construct(PostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    public function index()
    {
        $posts = $this->postRepository->all();

        return responder()->success($posts, new PostTransformer())->respond(200);
    }

    public function store(StorePostRequest $request)
    {
        $imagePath = $request->file('cover_image')->store('images', 'public');

        $post = $this->postRepository->create([
            'title'       => $request->title,
            'body'        => $request->body,
            'cover_image' => $imagePath,
            'pinned'      => $request->pinned,
        ]);

        if ($request->tags) {
            $post->tags()->attach($request->tags);
        }

        return response()->json($post, 201);
    }

    public function show(Post $post)
    {
        if ($post->user_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        return response()->json($post->load('tags'));
    }

    public function update(StorePostRequest $request, Post $post)
    {
        if ($post->user_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        if ($request->hasFile('cover_image')) {
            Storage::disk('public')->delete($post->cover_image);
            $imagePath = $request->file('cover_image')->store('images', 'public');
            $post->cover_image = $imagePath;
        }

        $post = $this->postRepository->update($post, $request->only('title', 'body', 'pinned'));
        $post->tags()->sync($request->tags);

        return response()->json($post);
    }

    public function destroy(Post $post)
    {
        if ($post->user_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $this->postRepository->delete($post);

        return response()->json(['message' => trans('messages.post_deleted')]);
    }

    public function trashed()
    {
        $posts = $this->postRepository->trashed();

        return response()->json($posts);
    }

    public function restore($id)
    {
        $post = $this->postRepository->restore($id);

        return response()->json(['message' => trans('messages.post_restored')]);
    }
}
