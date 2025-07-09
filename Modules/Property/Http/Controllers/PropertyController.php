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

        $query->with([
            'prices' => function ($q) {
                $q->select('price', 'currency', 'property_id', 'created_at')
                    ->orderBy('created_at', 'desc');
            },
            'firstImage' => function ($q) {
                $q->select('type', 'path', 'imageable_id', 'imageable_type');
            }
        ]);

        if (!empty($request->query())) {
            if ($request->has('priceMin')) {
                $query->whereHas('prices', fn($q) => $q->where('price', '>=', (int)$request->query('priceMin')));
            }
            if ($request->has('priceMax')) {
                $query->whereHas('prices', fn($q) => $q->where('price', '<=', (int)$request->query('priceMax')));
            }

            $filters = [
                'propertyCondition' => ['column' => 'property_condition', 'transform' => fn($v) => Enum::check(RepairType::class, $v)],
                'adType' => 'add_type',
                'buildingType' => ['column' => 'building_type', 'transform' => fn($v) => Enum::check(PropertyType::class, $v)],
                'roomCount' => 'number_of_rooms',
                'cityId' => 'city_id',
                'townId' => 'town_id',
                'subwayId' => 'subway_id',
                'districtId' => 'district_id',
                'adNo' => 'add_no',
                'address' => 'address',
                'numberOfFloors' => 'number_of_floors',
                'floorLocated' => 'floor_located',
                'inCredit' => 'in_credit',
                'hasVideo' => 'has_video',
            ];

            foreach ($filters as $param => $config) {
                if ($request->has($param)) {
                    $column = is_array($config) ? $config['column'] : $config;
                    $value = $request->query($param);
                    if (is_array($config) && isset($config['transform'])) {
                        $value = $config['transform']($value);
                    }
                    $query->where($column, $value);
                }
            }

            foreach (['area', 'field_area'] as $rangeParam) {
                $min = $request->input("$rangeParam.min");
                $max = $request->input("$rangeParam.max");

                if ($min !== null || $max !== null) {
                    $query->whereBetween($rangeParam, [
                        $min ?? 0,
                        $max ?? PHP_INT_MAX
                    ]);
                }
            }

            $limit = $request->integer('limit', config('default.default_property_limit'));

            $properties = $query->orderBy('created_at', 'desc')
                ->paginate($limit)
                ->appends($request->query());

            return PropertyListResource::collection($properties);
        }

        $propertyGroups = [];
        foreach (PropertyType::cases() as $type) {
            $groupQuery = Property::query()
                ->with([
                    'prices' => fn($q) => $q->select('price', 'currency', 'property_id', 'created_at')->orderBy('created_at', 'desc'),
                    'firstImage' => fn($q) => $q->select('type', 'path', 'imageable_id', 'imageable_type'),
                ])
                ->where('building_type', $type->value)
                ->limit(config('default.default_property_limit'));

            $propertyGroups[$type->label()] = PropertyListResource::collection($groupQuery->get());
        }

        return response()->json(["data" => $propertyGroups]);
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

    public function agencyProperties(Request $request, int $agencyId)
    {
        if ($request->has('add_type')) {
            $query = Property::query()
                ->with([
                    'prices' => function ($q) {
                        $q->select('price', 'currency', 'property_id', 'created_at')->orderBy('created_at', 'desc');
                    },
                    'firstImage' => function ($q) {
                        $q->select('type', 'path', 'imageable_id', 'imageable_type');
                    }
                ])
                ->where('user_id', $agencyId)
                ->where('add_type', $request->query('add_type'));

            $properties = $query->paginate(config('default.default_property_limit'));

            return PropertyListResource::collection($properties);
        }

        $propertyGroups = [];

        foreach (PropertyType::cases() as $type) {
            $groupQuery = Property::query()
                ->with([
                    'prices' => function ($q) {
                        $q->select('price', 'currency', 'property_id', 'created_at')->orderBy('created_at', 'desc');
                    },
                    'firstImage' => function ($q) {
                        $q->select('type', 'path', 'imageable_id', 'imageable_type');
                    }
                ])
                ->where('user_id', $agencyId)
                ->where('building_type', $type->value)
                ->limit(config('default.default_property_limit'));

            $propertyGroups[$type->label()] = PropertyListResource::collection($groupQuery->get());
        }
        return response()->json(["data" => $propertyGroups]);
    }

}
