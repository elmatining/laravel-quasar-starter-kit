<?php

namespace App\Http\Resources\User;

use App\Http\Resources\User\UserRelationshipResource;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'type'       => 'users',
            'id'         => (string)$this->id,
            'attributes' => [
                'name'  => $this->name,
                'email' => $this->email,
                'roles' => $this->roles->pluck('name')->toArray()
            ],
            'relationships' => new UserRelationshipResource($this),
            'links' => [
                'self' => route('users.show', ['user' => $this->id])
            ]
        ];
    }
}
