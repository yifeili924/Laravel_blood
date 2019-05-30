<?php
/**
 * Created by PhpStorm.
 * User: iku
 * Date: 2019-03-09
 * Time: 7:31 PM
 */

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    public function comments()
    {
        return $this->morphMany(Icomment::class, 'commentable')->whereNull('parent_id');
    }
}