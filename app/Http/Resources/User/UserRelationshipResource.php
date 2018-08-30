<?php namespace App\Http\Resources\User;

use App\Http\Resources\User\UserProfileIdentifierResource;
use Illuminate\Http\Resources\Json\JsonResource;

class UserRelationshipResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
          'profile' => [
              'links' => [
                  'self' => route('users.relationships.profile', ['user' => $this->id]),
                  'related' => route('users.profile', ['user' => $this->id]),
              ],
              'data' => new UserProfileIdentifierResource($this->profile),
          ],
        ];
    }

    public function with($request)
    {
        return [
          'links' => [
              'self' => route('users.index'),
          ],
        ];
    }
}
