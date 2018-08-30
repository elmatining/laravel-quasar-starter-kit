<?php namespace App\Http\Resources\User;

use App\Http\Resources\User\UserProfileResource;
use App\Http\Resources\User\UserResource;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Collection;
use App\Models\SocialAccount;

class UsersResource extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'data' => UserResource::collection($this->collection),
        ];
    }

    public function withIncluded(Collection $included)
    {
        return $included->map(
            function ($include) {
                if ($include instanceof SocialAccount) {
                    return new UserProfileResource($include);
                }
            }
        );
    }
}
