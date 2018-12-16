<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

/**
 * Class Team
 *
 * @package App\Http\Resources
 */
class Team extends Resource
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
            'name' => $this->name,
            'created_at' => $this->formatDateTime($this->created_at),
            'updated_at' => $this->formatDateTime($this->updated_at),
            'players' =>  Player::collection($this->whenLoaded('players'))
        ];
    }
}
