<?php

namespace App\Http\Resources\Api\V1;

use App\Models\BookingTransaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Override;

class CourtResource extends JsonResource
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
            'name'  => $this->name,
            'court_schedule' => $this->whenLoaded('court_schedule'),
            'schedules' => $this->when($this->court_schedule !== null, function() {
                return $this->generateSchedules();
            }),
        ];
    }

    private function generateSchedules() {
        $court_schedule = $this->court_schedule;
        $day = $court_schedule->day;
        $open_time = Carbon::parse($court_schedule->open_time);
        $close_time = Carbon::parse($court_schedule->close_time);
        $schedules = [];

        $count = $open_time->diffInHours($close_time);
        for($i = 0; $i < round($count); $i++) {
            $start_time = $open_time->copy()->addHours($i);
            $end_time = $start_time->copy()->addHour();
            
            $schedules[] = (object) [
                'day'        => $day,
                'start_time' => $start_time->format('H:i'),
                'end_time'   => $end_time->format('H:i'),
                'status'     => $this->checkStatus($start_time, $end_time), // available or booked
            ];
        } 

        return $schedules;
    }

    private function checkStatus($start_time, $end_time) {
        $start_time = Carbon::parse($start_time)->format('H:i:s');
        $end_time = Carbon::parse($end_time)->format('H:i:s');
        $booking_transactions = BookingTransaction::where('court_schedule_id', $this->court_schedule->id)
                                    ->where('start_time', $start_time)
                                    ->where('end_time', $end_time)
                                    ->count();
        
        $status = 'available';
        if(!empty($booking_transactions)) {
            $status = 'booked';
        }

        return $status;
    }
}
