<?php namespace App\Http\Resources\Auth;

use Illuminate\Http\Resources\Json\JsonResource;

class RoleRelationshipResource extends JsonResource
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
            'permissions' => new PermissionsResource($this->permissions),
        ];
    }
}
