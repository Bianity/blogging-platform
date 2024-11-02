<?php

namespace App\Repositories;

use Cviebrock\EloquentTaggable\Models\Tag;

class TagRepository extends BaseRepository
{
    public function model()
    {
        return Tag::class;
    }
}
