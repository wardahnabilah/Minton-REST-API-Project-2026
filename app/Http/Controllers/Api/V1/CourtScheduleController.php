<?php

namespace App\Http\Controllers\Api\V1;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\StoreCourtScheduleRequest;
use App\Http\Resources\Api\V1\CourtResource;
use App\Http\Resources\Api\V1\CourtScheduleResource;
use App\Models\CourtSchedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CourtScheduleController extends Controller
{
    public function index() {
        $schedules = CourtSchedule::with('court:id,name')->paginate(10);
        $resource = CourtScheduleResource::collection($schedules)->response()->getData();

        return ApiResponse::success(
            $resource->data,
            'court schedules retrieved successfully',
            200,
            $resource->meta,
            $resource->links,
        );
    }

    public function store(StoreCourtScheduleRequest $request, $return_response = true) {
        $schedule = CourtSchedule::create([
            'court_id'  => $request->court_id,
            'day'       => $request->day,
            'open_time' => $request->open_time,
            'close_time' => $request->close_time,
            'created_by' => auth()->user()->id,
        ]);

        if(!$return_response) return $schedule;

        return ApiResponse::success(
            new CourtScheduleResource($schedule),
            'court schedule created successfully',
            201,
        );
    }

    public function update(StoreCourtScheduleRequest $request, $id) {
        DB::transaction(function () use ($request, $id) {
            // create new data
            $new_schedule = $this->store($request, false);

            // delete old data
            $old_schedule = $this->destroy($id, false);

            return ApiResponse::success(
                new CourtScheduleResource($new_schedule),
                'court schedule updated successfully',
                201,
            );
        });
    }

    public function destroy($id, $return_response = true) {
        $schedule = CourtSchedule::findOrFail($id);
        $schedule->deleted_by = auth()->user()->id;
        $schedule->save();
        $schedule->delete();

        if(!$return_response) return null;

        return ApiResponse::success(
            null,
            'court schedule deleted successfully',
            200,
        );
    }
}
