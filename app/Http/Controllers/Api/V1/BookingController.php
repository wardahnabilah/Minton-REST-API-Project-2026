<?php

namespace App\Http\Controllers\Api\V1;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\StoreBookingRequest;
use App\Http\Resources\Api\V1\BookingResource;
use App\Models\BookingTransaction;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index() {
        $bookings = BookingTransaction::where('user_id', auth()->user()->id)->paginate(10);

        return ApiResponse::success(
            BookingResource::collection($bookings),
            'booking data retrieved successfully',
            200,
        );
    }


    public function store(StoreBookingRequest $request) {
        $date = Carbon::createFromFormat('d/m/Y', $request->date);
        $booking = BookingTransaction::create([
            'user_id'           => auth()->user()->id,
            'court_schedule_id' => $request->court_schedule_id,
            'date'              => $date,
            'start_time'        => $request->start_time,
            'end_time'          => $request->end_time,         
            'status'            => 'booked',
        ]);

        return ApiResponse::success(
            new BookingResource($booking),
            'booking created succesfully',
            201
        );
    }

    public function show($id) {
        $booking = BookingTransaction::findOrFail($id);

        return ApiResponse::success(
            new BookingResource($booking),
            'booking detail retrieved successfully',
            200
        );
    }

    public function destroy($id) {
        $booking = BookingTransaction::findOrFail($id);

        if(!auth()->user()->can('delete', $booking)) {
            return ApiResponse::error(
                null,
                'Unauthorized',
                403,
            );
        }

        $booking->delete();

        return ApiResponse::success(
            null,
            'booking deleted successfully',
            200
        );
    }

}
