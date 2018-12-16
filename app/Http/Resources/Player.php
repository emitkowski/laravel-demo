<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

/**
 * Class Player
 *
 * @package App\Http\Resources
 */
class Player extends Resource
{
    use ResourceFormatter;

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => (int) $this->id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'created_at' => $this->formatDateTime($this->created_at),
            'updated_at' => $this->formatDateTime($this->updated_at),
            'team' => $this->whenLoaded('teams')
        ];
    }
}
