<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePostRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'title'       => 'sometimes|required|string|max:255',
            'body'        => 'sometimes|required|string',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'pinned'      => 'sometimes|boolean',
            'tags'        => 'sometimes|array',
            'tags.*'      => 'exists:tags,id',
        ];
    }
}
