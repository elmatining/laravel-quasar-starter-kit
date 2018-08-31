<?php namespace App\Http\Resources\Auth;

use Illuminate\Http\Resources\Json\ResourceCollection;

class RolesResource extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'data' => RoleResource::collection($this->collection),
        ];
    }
}
