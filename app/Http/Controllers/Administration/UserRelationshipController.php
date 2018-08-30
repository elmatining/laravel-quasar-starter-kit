<?php namespace App\Http\Controllers\Administration;

use App\Http\Controllers\Controller;
use App\Http\Resources\User\UserProfileResource;
use App\Models\User;

class UserRelationshipController extends Controller
{
    public function profile(User $user)
    {
        return new UserProfileResource($user->profile);
    }
}
