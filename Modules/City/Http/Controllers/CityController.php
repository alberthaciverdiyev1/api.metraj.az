<?php

namespace Modules\City\Http\Controllers;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Str;
use Modules\City\Http\Entities\City;
use Modules\City\Http\Requests\CityStoreRequest;
use Modules\City\Http\Requests\CityUpdateRequest;
use Modules\City\Http\Transformers\CityResource;

class CityController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function list()
    {
        $cities = City::query()
            ->select('id', 'name')
            ->where('is_active', 1)
            ->get();

        return CityResource::collection($cities);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CityStoreRequest $request)
    {
        try {
            $validatedData = $request->safe()->toArray();

            City::query()->create($validatedData);

            return response()->json([
                'message' => 'City created successfully.',
                'status_code' => 201
            ]);
        } catch (Exception $e) {
            return response()->json($e->getMessage());
        }
    }

    public function update(string $id, CityUpdateRequest $request)
    {
        try {
            $validatedData = $request->safe()->toArray();

            $updated = City::query()->where('id', $id)->update($validatedData);

            if ($updated) {
                return response()->json([
                    'message' => 'City updated successfully.',
                    'status_code' => 201
                ]);
            } else {
                return response()->json([
                    'message' => 'City not found or no changes detected.',
                    'status_code' => 404
                ]);
            }

        } catch (Exception $e) {
            return response()->json($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        try {
            City::query()->where('id', $id)->delete();
            return response()->json([
                'message' => 'City deleted successfully.',
                'status_code' => 200
            ]);
        } catch (Exception $e) {
            return response()->json($e->getMessage());
        }
    }
}
