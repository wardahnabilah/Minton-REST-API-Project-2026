<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CourtScheduleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'        => $this->id,
            'court_id'  => $this->whenLoaded('court'),
            'day'       => $this->day,
            'open_time' => $this->open_time,
            'close_time' => $this->close_time,
        ];
    }
}
