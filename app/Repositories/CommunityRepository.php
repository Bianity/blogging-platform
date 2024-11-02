<?php

namespace App\Repositories;

use App\Models\Community;

class CommunityRepository extends BaseRepository
{
    public function model()
    {
        return Community::class;
    }
}
