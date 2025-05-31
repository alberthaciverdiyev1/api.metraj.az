<?php

namespace Modules\District\Http\Controllers;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Routing\Controller;
use Illuminate\Support\Str;
use Modules\District\Http\Entities\District;
use Modules\District\Http\Requests\DistrictStoreRequest;
use Modules\District\Http\Requests\DistrictUpdateRequest;
use Modules\District\Http\Transformers\DistrictResource;
use Nwidart\Modules\Facades\Module;

class DistrictController extends Controller
{

    public function __construct()
    {
//        if (Module::find('Roles')->isEnabled()) {
//            $this->middleware('permission:view districts')->only('index');
//            $this->middleware('permission:create district')->only('create');
//            $this->middleware('permission:store district')->only('store');
//            $this->middleware('permission:edit district')->only('edit');
//            $this->middleware('permission:update district')->only('update');
//            $this->middleware('permission:destroy district')->only('destroy');
//        }
    }

    /**
     * Display a listing of the resource.
     */
    public function list(): AnonymousResourceCollection
    {
        $blogs = District::query()
            ->select('id', 'name', 'slug', 'city_id')
            ->with([
                'city' => function ($query) {
                    $query->select('id', 'name', 'is_active');
                }
            ])
            ->latest()
            ->get();


        return DistrictResource::collection($blogs);
    }

    public function details(string $slug)
    {
//        $blog = District::query()
//            ->select('id', 'name', 'slug', 'city_id')
//            ->with([
//                'category:id,name,slug',
//                'tags:id,name,slug'
//            ])
//            ->where('slug', $slug)
//            ->first();
//
//        if (!$blog) {
//            return response()->json([
//                'success' => 400,
//                'message' => __('Blog not found!')
//            ]);
//        }
//
//        return BlogDetailsResource::make($blog);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DistrictStoreRequest $request): JsonResponse
    {
        try {
            $validatedData = $request->safe()->toArray();

            District::query()->create($validatedData);

            return response()->json([
                'message' => 'District created successfully.',
                'status_code' => 201
            ]);
        } catch (Exception $e) {
            return response()->json($e->getMessage());
        }
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(string $slug, DistrictUpdateRequest $request)
    {
        try {
            $validatedData = $request->safe()->toArray();
            $validatedData['slug'] = Str::slug($validatedData['name']) . '-' . rand(10, 1000000);

            $updated = District::query()->where('slug', $slug)->update($validatedData);
            if ($updated) {
                return response()->json([
                    'message' => 'District updated successfully.',
                    'status_code' => 201
                ]);
            } else {
                return response()->json([
                    'message' => 'District not found or no changes detected.',
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
    public function destroy(string $slug): JsonResponse
    {
        try {
            District::query()->where('slug', $slug)->delete();
            return response()->json([
                'message' => 'District deleted successfully.',
                'status_code' => 200
            ]);
        } catch (Exception $e) {
            return response()->json($e->getMessage());
        }
    }
}
