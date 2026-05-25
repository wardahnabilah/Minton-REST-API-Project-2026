<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'    => $this->id,
            'user_id' => $this->user_id,
            'court_schedule_id' => $this->court_schedule_id,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
        ];
    }
}
