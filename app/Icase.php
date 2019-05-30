<?php

namespace App;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Icase extends Model
{

    protected $appends = ['p_d', 'c_d'];
    protected $dates = [
                        'created_at',
                        'updated_at',
                        'publish_date',
                        'closing_date'
                        ];
    public function getPDAttribute()
    {
        return $this->publish_date->format("Y-m-d");
    }
    public function getCDAttribute()
    {
        return $this->closing_date->format("Y-m-d");
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function slides()
    {
        return $this->hasMany(Slide::class);
    }

    public function submissions()
    {
        return $this->hasMany(Submission::class);
    }

    public function campaigns()
    {
        return $this->hasMany(Campaign::class);
    }
}
