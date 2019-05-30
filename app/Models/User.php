<?php namespace App\Models;

use App\Comment;
use App\Icase;
use App\Submission;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use App\Notifications\ResetPassword as ResetPasswordNotification;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract
{
    use Authenticatable, CanResetPassword, Notifiable;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    public function roles()
    {
        return $this->belongsToMany('App\Models\Role')->withTimestamps();
    }

    public function hasRole($name)
    {   
        
        foreach($this->roles as $role)
        {
            if($role->name == $name) return true;
        }

        return false;
    }

    public function assignRole($role)
    {
        return $this->roles()->attach($role);
    }

    public function removeRole($role)
    {
        return $this->roles()->detach($role);
    }

    public function social()
    {
        return $this->hasMany('App\Models\Social');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function icases()
    {
        return $this->hasMany(Icase::class);
    }

    public function submissions()
    {
        return $this->hasMany(Submission::class);
    }

    public function homeUrl()
    {
        if ($this->hasRole('user')) {
            $url = route('user.home');
        } else {
            $url = route('admin.home');
        }

        return $url;
    }

    public function getDetailsAttribute()
    {
        return "{$this->first_name} {$this->last_name} {$this->email}";
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }
}
