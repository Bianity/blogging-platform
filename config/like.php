<?php

use App\Models\Like;
use App\Models\User;

return [
    /*
     * Use uuid as primary key.
     */
    'uuids' => false,

    /*
     * User tables foreign key name.
     */
    'user_foreign_key' => 'user_id',

    /*
     * Table name for likes records.
     */
    'likes_table' => 'likes',

    /*
     * Model name for like record.
     */
    'like_model' => Like::class,

    /*
     * Model name for liker.
     */
    'user_model' => class_exists(User::class) ? User::class : null,
];
