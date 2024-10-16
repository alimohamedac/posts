<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Transformers\PostTransformer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $user = auth()->user();

        if (!$user) {
            return response()->json(['error' => 'User not authenticated'], 401);
        }

        $posts = $user->posts()->with('tags')
            ->orderByDesc('pinned')
            ->get();

        return responder()->success($posts, new PostTransformer())->respond(200);
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
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title'       => 'required|string|max:255',
            'body'        => 'required|string',
            'cover_image' => 'required|image',
            'pinned'      => 'required|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $imagePath = $request->file('cover_image')->store('images', 'public');

        $post = auth()->user()->posts()->create([
            'title'       => $request->title,
            'body'        => $request->body,
            'cover_image' => $imagePath,
            'pinned'      => $request->pinned,
        ]);

        $post->tags()->attach($request->tags);

        return response()->json($post, 201);
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Post $post)
    {
        if ($post->user_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        return response()->json($post->load('tags'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
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
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Post $post)
    {
        if ($post->user_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $validator = Validator::make($request->all(), [
            'title'       => 'required|string|max:255',
            'body'        => 'required|string',
            'cover_image' => 'sometimes|image',
            'pinned'      => 'required|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        if ($request->hasFile('cover_image')) {
            Storage::disk('public')->delete($post->cover_image);
            $imagePath = $request->file('cover_image')->store('images', 'public');
            $post->cover_image = $imagePath;
        }

        $post->update($request->only('title', 'body', 'pinned'));

        $post->tags()->sync($request->tags);

        return response()->json($post);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Post $post)
    {
        if ($post->user_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $post->delete();

        return response()->json(['message' => 'Post soft-deleted successfully']);
    }

    public function trashed()
    {
        $posts = auth()->user()->posts()->onlyTrashed()->get();

        return response()->json($posts);
    }

    public function restore($id)
    {
        $post = auth()->user()->posts()->onlyTrashed()->findOrFail($id);
        $post->restore();

        return response()->json(['message' => 'Post restored successfully']);
    }

}
