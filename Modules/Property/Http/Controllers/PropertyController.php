<?php

namespace Modules\Property\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Property\Http\Transformers\PropertyDetailsResource;
use Modules\Property\Http\Transformers\PropertyListResource;
use Nwidart\Modules\Facades\Module;
use Modules\Property\Http\Entities\Property;

class PropertyController extends Controller
{

    public function __construct()
    {
//        if (Module::find('Roles')->isEnabled()) {
//            $this->middleware('permission:view propertys')->only('index');
//            $this->middleware('permission:create property')->only('create');
//            $this->middleware('permission:store property')->only('store');
//            $this->middleware('permission:edit property')->only('edit');
//            $this->middleware('permission:update property')->only('update');
//            $this->middleware('permission:destroy property')->only('destroy');
//        }
    }


    /**
     * Display a listing of the resource.
     */
    public function list(Request $request)
    {
        $relations = $request->query('with', []);
        $query = Property::query()->when($relations, fn($q) => $q->with($relations));

        $params = [
            'property_type' => $request->query('property-type')
        ];

        if ($params['property_type']) {
            $query = $query->where('property_type', $params['property_type']);
        }


        foreach (['area', 'field_area'] as $rangeParam) {
            if ($request->has("$rangeParam.min") || $request->has("$rangeParam.max")) {
                $query->whereBetween($rangeParam, [
                    $request->input("$rangeParam.min", 0),
                    $request->input("$rangeParam.max", PHP_INT_MAX)
                ]);
            }
        }

        $limit = $request->integer('limit', config('default.default_property_limit'));
        $properties = $query->paginate($limit)->appends($request->query());

        return PropertyListResource::collection($properties);
    }


    public function details($id)
    {
        $property = Property::query()
            ->where('id', $id)
            ->with(['city', 'district', 'subway'])
            ->firstOrFail();
        return new PropertyDetailsResource($property);
    }


    /**
     * Show the specified resource.
     */
    public function show()
    {
        return view('property::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
    {
        return view('property::edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        try {

            //TODO:UPDATE FUNCTIONS

            return response()->json(__('Data successfully updated!'));
        } catch (Exception $e) {
            return response()->json($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy()
    {
        try {

            //TODO:DESTROY FUNCTIONS

            return response()->json(__('Data successfully deleted!'));
        } catch (Exception $e) {
            return response()->json($e->getMessage());
        }
    }
}
