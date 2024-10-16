<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTagRequest;
use App\Http\Requests\UpdateTagRequest;
use App\Repositories\TagRepository;
use App\Transformers\TagTransformer;

class TagController extends Controller
{
    protected $tagRepository;

    public function __construct(TagRepository $tagRepository)
    {
        $this->tagRepository = $tagRepository;
    }

    public function index()
    {
        $tags = $this->tagRepository->getAll();

        return responder()->success($tags, new TagTransformer())->respond(200);
    }

    public function store(StoreTagRequest $request)
    {
        $tag = $this->tagRepository->create($request->validated());

        return response()->json([
            'tag'     => $tag,
            'message' => trans('messages.tag_created')
        ], 201);
    }

    public function show($id)
    {
        $tag = $this->tagRepository->find($id);

        if (!$tag) {
            return response()->json([
                trans('messages.tag_not_found')
            ], 404);
        }

        return response()->json($tag);
    }

    public function update(UpdateTagRequest $request, $id)
    {
        $updated = $this->tagRepository->update($id, $request->validated());

        if (!$updated) {
            return response()->json(['message' => trans('messages.error_occurred')], 404);
        }

        return response()->json(['message' => trans('messages.tag_updated')]);
    }

    public function destroy($id)
    {
        $deleted = $this->tagRepository->delete($id);

        if (!$deleted) {
            return response()->json(['message' => trans('messages.error_occurred')], 404);
        }

        return response()->json(['message' => trans('messages.tag_deleted')]);
    }
}
