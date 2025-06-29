<?php

namespace Modules\Property\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
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
        },
            'firstImage' => function ($query) {
                $query->select('type', 'path', 'imageable_id', 'imageable_type');
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
        if ($request->query('city-id')) {
            $query = $query->where('city_id', (integer)$request->query('city-id'));
        }
        if ($request->query('town-id')) {
            $query = $query->where('town_id', (integer)$request->query('town-id'));
        }
        if ($request->query('subway-id')) {
            $query = $query->where('subway_id', (integer)$request->query('subway-id'));
        }
        if ($request->query('district-id')) {
            $query = $query->where('district_id', (integer)$request->query('district-id'));
        }
        if ($request->query('price-min')) {
            $query = $query->where('price', '>=', (integer)$request->query('price-min'));
        }
        if ($request->query('price-max')) {
            $query = $query->where('price', '<=', (integer)$request->query('price-max'));
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
        $properties = $query->orderBy('created_at', 'desc')->paginate($limit)->appends($request->query());
        return PropertyListResource::collection($properties);
    }


    public function details($id)
    {
        $property = Property::query()
            ->where('id', $id)
            ->with([
                'city',
                'district',
                'subway',
                'media',
                'features',
                'prices' => function ($query) {
                    $query->select('price', 'currency', 'property_id', 'created_at')
                        ->orderBy('created_at', 'desc');
                },
                'nearbyObjects'
            ])
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
        $media = $validated['media'] ?? null;
        $features = $validated['features'] ?? [];
        $nearby_objects = $validated['nearby_objects'] ?? [];
        unset($validated['price'], $validated['media'], $validated['features'], $validated['nearby_objects']);


        $property = Property::create($validated);

        Price::create([
            'property_id' => $property->id,
            'price' => $price,
            'currency' => Enum::check(Currency::class, 'AZN'),
        ]);
        $property->media()->createMany($media);
        $property->features()->attach($features);
        $property->nearbyObjects()->attach($nearby_objects);

        return new PropertyDetailsResource($property);
    }

    public function update()
    {
        //  $property->features()->sync([1, 2, 3]);

    }

    public function agencyProperties(Request $request, int $agencyId):AnonymousResourceCollection
    {
        $properties = Property::query()->with(
            ['prices' => function ($query) {
                $query->select('price', 'currency', 'property_id', 'created_at')->orderBy('created_at', 'desc');
            },
                'firstImage' => function ($query) {
                    $query->select('type', 'path', 'imageable_id', 'imageable_type');
                }])
            ->where('user_id', $agencyId)->get();

        return PropertyListResource::collection($properties);
    }

}
