<?php

namespace App\Transformers;

use Flugg\Responder\Transformers\Transformer;

class PostTransformer extends Transformer
{
    public function transform($post): array
    {
        return [
            'id'         => $post->id,
            'title'      => $post->title,
            'body'       => $post->body,
            'image'      => $post->cover_image,
            'pinned'     => $post->pinned,
            'created_at' => $post->created_at,
            'updated_at' => $post->updated_at,
        ];
    }
}
