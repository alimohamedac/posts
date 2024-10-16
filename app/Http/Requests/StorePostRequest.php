<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'title'       => 'required|string|max:255',
            'body'        => 'required|string',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'pinned'      => 'sometimes|boolean',
            'tags'        => 'required|array',
            'tags.*'      => 'exists:tags,id',
        ];
    }
}
