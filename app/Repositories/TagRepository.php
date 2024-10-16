<?php

namespace App\Repositories;

use App\Models\Tag;

class TagRepository
{
    protected $model;

    public function __construct(Tag $model)
    {
        $this->model = $model;
    }

    public function getAll()
    {
        return $this->model->all();
    }

    public function find($id)
    {
        return $this->model->find($id);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update($id, array $data)
    {
        $tag = $this->model->find($id);

        if ($tag) {
            return $tag->update($data);
        }

        return false;
    }

    public function delete($id)
    {
        $tag = $this->model->find($id);

        if ($tag) {
            return $tag->delete();
        }

        return false;
    }
}
