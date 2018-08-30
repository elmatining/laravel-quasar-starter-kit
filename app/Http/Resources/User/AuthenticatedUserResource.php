<?php namespace App\Http\Resources\User;

use Illuminate\Http\Resources\Json\JsonResource;

class AuthenticatedUserResource extends JsonResource
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
            'id'       => (string)$this->id,
            'name'     => $this->name,
            'email'    => $this->email,
            'avatar'   => $this->profile->avatar,
            'provider' => $this->profile->provider,
        ];
    }
}
