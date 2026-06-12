<?php

namespace App\Http\Controllers\Api\V1;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\StoreCourtRequest;
use App\Http\Resources\Api\V1\CourtResource;
use App\Models\Court;
use Illuminate\Http\Request;
use Illuminate\Session\Store;

class CourtController extends Controller
{
    public function index() {
        $courts = Court::with('court_schedule')->paginate(10);

        return ApiResponse::success(
            CourtResource::collection($courts),
            'data retrieved successfully',
            200,
        );
    }

    public function store(StoreCourtRequest $request) {
        $court = Court::create([
            'name'       => $request->name,
            'created_by' => auth()->user()->id,
        ]);

        return ApiResponse::success(
            new CourtResource($court),
            'court created successfully',
            201,
        );
    }

    public function update(StoreCourtRequest $request, $id) {
        $court = Court::findOrFail($id);

        $court->update([
            'name'       => $request->name,
            'updated_by' => auth()->user()->id,
        ]);

        return ApiResponse::success(
            new CourtResource($court),
            'court successfully updated',
            200
        );
    }

    public function destroy($id) {
        $court = Court::findOrFail($id);
        $court->deleted_by = auth()->user()->id;
        $court->save();
        $court->delete();

        return ApiResponse::success(
            null, 
            'court successfully deleted',
            200,
        );
    }

}
