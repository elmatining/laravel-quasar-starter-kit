<?php namespace App\Http\Resources\User;

use Illuminate\Http\Resources\Json\JsonResource;

class UserProfileResource extends JsonResource
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
            'type'       => 'profile',
            'id'         => (string)$this->id,
            'attributes' => [
                'provider'    => $this->provider,
                'provider_id' => (string)$this->provider_id,
                'avatar'      => $this->avatar
            ]
        ];
    }
}
