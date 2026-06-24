<?php

namespace App\Http\Resources\Api\V1;

use App\Models\BookingTransaction;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
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
            'court'     => $this->whenLoaded('court'),
            'day'       => $this->day,
            'date'      => $this->getDate(),
            'open_time' => $this->open_time,
            'close_time' => $this->close_time,
            'slots'     => $this->generateSlots(),
        ];
    }

    private function getDate() {
        $day = $this->day;

        // get the date within the next 7 days, based on day name
        $period = CarbonPeriod::create(now(), now()->addDays(7));
        $date = collect($period)->filter(function ($item) use ($day) {
            return strtolower($item->format('l')) === $day;
        });

        return $date->first()->format('d/m/Y');
    }

    private function generateSlots() {
        $open_time = Carbon::parse($this->open_time);
        $close_time = Carbon::parse($this->close_time);
        $slots = [];

        $count = $open_time->diffInHours($close_time);
        for($i = 0; $i < round($count); $i++) {
            $start_time = $open_time->copy()->addHours($i);
            $end_time = $start_time->copy()->addHour();
            
            $slots[] = (object) [
                'start_time' => $start_time->format('H:i'),
                'end_time'   => $end_time->format('H:i'),
                'status'     => $this->checkStatus($start_time, $end_time), // available or booked
            ];
        } 

        return $slots;
    }

    private function checkStatus($start_time, $end_time) {
        $start_time = Carbon::parse($start_time)->format('H:i:s');
        $end_time = Carbon::parse($end_time)->format('H:i:s');
        $booking_transactions = BookingTransaction::where('court_schedule_id', $this->id)
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
