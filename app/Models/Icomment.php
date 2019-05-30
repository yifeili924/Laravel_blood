<?php
/**
 * Created by PhpStorm.
 * User: iku
 * Date: 2019-03-11
 * Time: 9:11 AM
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Icomment extends Model
{
    protected $table = 'icomments';
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function replies()
    {
        return $this->hasMany(Icomment::class, 'parent_id');
    }
}