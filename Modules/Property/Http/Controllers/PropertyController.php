<?php

namespace Modules\Property\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
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
        $query     = Property::query()->when($relations, fn ($q) => $q->with($relations));

        $map = [
            'type'            => 'type',
            'add_no'          => 'add_no',
            'town_id'         => 'town_id',
            'subway_id'       => 'subway_id',
            'district_id'     => 'district_id',
            'city_id'         => 'city_id',
            'property_type'   => 'property_type',
            'add_type'        => 'add_type',
            'number_of_floors'=> 'number_of_floors',
            'number_of_rooms' => 'number_of_rooms',
            'floor_located'   => 'floor_located',
            'in_credit'       => 'in_credit',
        ];

        foreach ($map as $param => $column) {
            if ($request->filled($param)) {
                $query->where($column, $request->query($param));
            }
        }

        foreach (['area', 'field_area'] as $rangeParam) {
            if ($request->has("$rangeParam.min") || $request->has("$rangeParam.max")) {
                $query->whereBetween($rangeParam, [
                    $request->input("$rangeParam.min", 0),
                    $request->input("$rangeParam.max", PHP_INT_MAX)
                ]);
            }
        }

        $limit      = $request->integer('limit', config('default.default_property_limit'));
        $properties = $query->paginate($limit)->appends($request->query());

        return PropertyListResource::collection($properties)
 ;
    }




    public function add(Request $request)
    {
        try {

            Property::create();

            return response()->json(__('Data successfully created!'));
        } catch (Exception $e) {
            return response()->json($e->getMessage());
        }
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
