<?php
/**
 * Created by PhpStorm.
 * User: iku
 * Date: 2019-03-20
 * Time: 12:37 PM
 */

namespace App;
use Illuminate\Database\Eloquent\Model;


class Guideline extends Model
{
    public function comments()
    {
        return $this->morphMany(\App\Models\Icomment::class, 'commentable')->whereNull('parent_id');
    }
}