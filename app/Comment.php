<?php

namespace App;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getCreatedAtAttribute($value)
    {
        return date("d-M-Y H:i",strtotime($value));
    }

    public function getUrl()
    {
        return "hello world";
    }
}
