<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Events\PostCreated;

class Post extends Model
{
    protected $fillable = [
        'user_id', 'body'
    ];

    //Events
    protected $dispatchesEvents = [
        'created' => PostCreated::class,
    ];
}
