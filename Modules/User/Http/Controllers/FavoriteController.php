<?php

namespace Modules\User\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;
use Modules\Property\Http\Transformers\PropertyListResource;
use Modules\User\Http\Entities\Favorite;
use Modules\User\Http\Transformers\FavoriteResource;

class FavoriteController extends Controller
{
    public function index()
    {
        $properties = auth()->user()
            ->favoriteProperties()
            ->get();

        return PropertyListResource::collection($properties);
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'property_id' => 'required|exists:properties,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }

        Favorite::create([
            'property_id' => $request->input('property_id'),
            'user_id' => auth()->id(),
        ]);

        return response()->json(['message' => 'Favorite added successfully'], 201);
    }

    public function destroy($property_id)
    {
        $deleted = Favorite::query()
            ->where('property_id', $property_id)
            ->where('user_id', auth()->id())
            ->delete();

        if ($deleted) {
            return response()->json(['message' => 'Favorite removed'], 200);
        }

        return response()->json(['message' => 'Favorite not found'], 404);
    }
}
