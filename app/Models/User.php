<?php namespace App\Models;

use Carbon\Carbon;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'username'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function profile()
    {
        return $this->hasOne(SocialAccount::class);
    }

    public function withValidToken()
    {
        $token = $this->tokens()
            ->whereName('Laravel Password Grant Client')
            ->first();

        if ($token && $token->expires_at >= Carbon::now()) {
            return $token;
        }

        return null;
    }
}
