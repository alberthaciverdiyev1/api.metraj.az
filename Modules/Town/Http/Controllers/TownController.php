<?php

namespace Modules\Town\Http\Controllers;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Routing\Controller;
use Illuminate\Support\Str;
use Modules\Town\Http\Entities\Town;
use Modules\Town\Http\Requests\TownStoreRequest;
use Modules\Town\Http\Requests\TownUpdateRequest;
use Modules\Town\Http\Transformers\TownResource;
use Nwidart\Modules\Facades\Module;

class TownController extends Controller
{

//    public function __construct()
//    {
//        if (Module::find('Roles')->isEnabled()) {
//            $this->middleware('permission:view towns')->only('index');
//            $this->middleware('permission:create town')->only('create');
//            $this->middleware('permission:store town')->only('store');
//            $this->middleware('permission:edit town')->only('edit');
//            $this->middleware('permission:update town')->only('update');
//            $this->middleware('permission:destroy town')->only('destroy');
//        }
//    }


    /**
    * Display a listing of the resource.
    */
    public function list(): AnonymousResourceCollection
    {
        $blogs = Town::query()
            ->select('id', 'name', 'slug', 'district_id')
            ->with([
                'city:id,name,slug,district_id',
                'district:id,name,slug'
            ])
            ->latest()
            ->get();

        return TownResource::collection($blogs);
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
    public function store(TownStoreRequest $request): JsonResponse
    {
        try {
            $validatedData = $request->safe()->toArray();

            Town::query()->create($validatedData);

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
    public function update(string $slug, TownUpdateRequest $request)
    {
        try {
            $validatedData = $request->safe()->toArray();
            $validatedData['slug'] = Str::slug($validatedData['name']) . '-' . rand(10, 1000000);

            $updated = Town::query()->where('slug', $slug)->update($validatedData);
            if ($updated) {
                return response()->json([
                    'message' => 'Town updated successfully.',
                    'status_code' => 201
                ]);
            } else {
                return response()->json([
                    'message' => 'Town not found or no changes detected.',
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
