<?php

namespace App\Http\Controllers\Api\V1;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\StoreCourtScheduleRequest;
use App\Http\Resources\Api\V1\CourtResource;
use App\Http\Resources\Api\V1\CourtScheduleResource;
use App\Models\CourtSchedule;
use Illuminate\Http\Request;

class CourtScheduleController extends Controller
{
    public function index() {
        $schedules = CourtSchedule::with('court:id,name')->paginate(10);

        return ApiResponse::success(
            CourtScheduleResource::collection($schedules),
            'court schedules retrieved successfully',
            200,
        );
    }

    public function store(StoreCourtScheduleRequest $request) {
        $schedule = CourtSchedule::create([
            'court_id'  => $request->court_id,
            'day'       => $request->day,
            'open_time' => $request->open_time,
            'close_time' => $request->close_time,
            'created_by' => auth()->user()->id,
        ]);

        return ApiResponse::success(
            new CourtScheduleResource($schedule),
            'court schedule created successfully',
            201,
        );
    }

    public function destroy($id) {
        $schedule = CourtSchedule::findOrFail($id);
        $schedule->deleted_by = auth()->user()->id;
        $schedule->save();
        $schedule->delete();

        return ApiResponse::success(
            null,
            'court schedule deleted successfully',
            200,
        );
    }
}
