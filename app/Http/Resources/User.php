<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class User extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $base = parent::toArray($request);

        $base['roles'] = $this->roles;
        $base['permissions'] = $this->permissions;

        return $base;
    }
}
