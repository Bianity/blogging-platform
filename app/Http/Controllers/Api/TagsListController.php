<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Cviebrock\EloquentTaggable\Models\Tag;

class TagsListController extends Controller
{
    public function tags()
    {
        return Tag::when(strlen(request('value')) >= 1, function ($query) {
            return $query->where('name', 'like', '%'.request('value').'%')->pluck('name')->toArray();
        });
    }
}
