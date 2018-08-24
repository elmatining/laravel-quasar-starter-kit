<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SocialAccount extends Model
{
    use SoftDeletes;
    protected $table = 'social_accounts';
    protected $dates = ['deleted_at'];
    protected $fillable = ['user_id', 'provider_id', 'provider', 'avatar'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
