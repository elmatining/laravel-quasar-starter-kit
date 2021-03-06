<?php namespace App\Http\Resources\Auth;

use Illuminate\Http\Resources\Json\JsonResource;

class RoleResource extends JsonResource
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
            'type' => 'role',
            'id' => (string)$this->id,
            'attributes' => [
                'name' => $this->name,
                'no_of_users' =>$this->users()->count()
            ],
            'relationships' => new RoleRelationshipResource($this),
        ];
    }
}
