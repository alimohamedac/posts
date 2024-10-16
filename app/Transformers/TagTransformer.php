<?php

namespace App\Transformers;

use Flugg\Responder\Transformers\Transformer;

class TagTransformer extends Transformer
{
    public function transform($tag): array
    {
        return [
            'id'         => $tag->id,
            'name'       => $tag->name,
            'created_at' => $tag->created_at,
            'updated_at' => $tag->updated_at,
        ];
    }
}
