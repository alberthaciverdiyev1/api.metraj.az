<?php

namespace Modules\Property\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Str;
use Modules\Base\Enums\Currency;
use Modules\Base\Enums\PropertyType;
use Modules\Base\Helpers\Enum;
use Modules\Price\Http\Entities\Price;
use Symfony\Component\HttpFoundation\Response;
use Modules\Base\Enums\RepairType;
use Modules\Property\Http\Requests\StoreProperty;
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

        $query = $query->with(['prices' => function ($query) {
            $query->select('price', 'currency', 'property_id', 'created_at')
                ->orderBy('created_at', 'desc');
        }]);

        if ($request->query('property-condition')) {
            $query = $query->where('property_condition', Enum::check(RepairType::class, $request->query('property-condition')));
        }
        if ($request->query('property-type')) {
            $query = $query->where('add_type', $request->query('property-type'));
        }
        if ($request->query('building-type')) {
            $query = $query->where('building_type', Enum::check(PropertyType::class, $request->query('building-type')));
        }
        if ($request->query('room-count')) {
            $query = $query->where('number_of_rooms', (integer)$request->query('room-count'));
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
        $properties = $query->orderBy('created_at','desc')->paginate($limit)->appends($request->query());
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

    public function add(StoreProperty $request)
    {
        $validated = $request->validated();

        $validated['property_condition'] = Enum::check(RepairType::class, $validated['property_condition']);
        $validated['building_type'] = Enum::check(PropertyType::class, $validated['building_type']);

        $validated['slug'] = Str::random(20);
        $price = $validated['price'] ?? null;
        unset($validated['price']);

        $property = Property::create($validated);

        Price::create([
            'property_id' => $property->id,
            'price' => $price,
            'currency' => Enum::check(Currency::class, 'AZN'),
        ]);

        return new PropertyDetailsResource($property);
    }

}
