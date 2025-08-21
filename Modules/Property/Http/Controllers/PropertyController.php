<?php

namespace Modules\Property\Http\Controllers;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
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
        $limit = $request->integer('limit', config('default.default_property_limit'));

        $baseQuery = Property::query()
            ->when($relations, fn($q) => $q->with($relations))
            ->with([
                'prices' => fn($q) => $q->select('price', 'currency', 'property_id', 'created_at')
                    ->orderBy('created_at', 'desc'),
                'firstImage' => fn($q) => $q->select('type', 'path', 'imageable_id', 'imageable_type'),
            ]);

        $filters = [
            'propertyCondition' => ['column' => 'property_condition', 'transform' => fn($v) => Enum::check(RepairType::class, $v)],
            'adType'           => 'add_type',
            'buildingType'     => ['column' => 'building_type', 'transform' => fn($v) => Enum::check(PropertyType::class, $v)],
            'roomCount'        => 'number_of_rooms',
            'cityId'           => 'city_id',
            'townId'           => 'town_id',
            'subwayId'         => 'subway_id',
            'districtId'       => 'district_id',
            'adNo'             => 'add_no',
            'address'          => 'address',
            'numberOfFloors'   => 'number_of_floors',
            'floorLocated'     => 'floor_located',
            'inCredit'         => 'in_credit',
            'hasVideo'         => 'has_video',
        ];

        foreach ($filters as $param => $config) {
            if ($request->has($param)) {
                $column = is_array($config) ? $config['column'] : $config;
                $value = $request->query($param);
                if (is_array($config) && isset($config['transform'])) {
                    $value = $config['transform']($value);
                }
                $baseQuery->where($column, $value);
            }
        }

        if ($request->filled('priceMin')) {
            $baseQuery->whereHas('prices', fn($q) => $q->where('price', '>=', (int)$request->query('priceMin')));
        }
        if ($request->filled('priceMax')) {
            $baseQuery->whereHas('prices', fn($q) => $q->where('price', '<=', (int)$request->query('priceMax')));
        }

        foreach (['area', 'fieldArea'] as $rangeParam) {
            $min = $request->input("{$rangeParam}Min");
            $max = $request->input("{$rangeParam}Max");
            if ($min !== null || $max !== null) {
                $baseQuery->whereBetween($rangeParam, [$min ?? 0, $max ?? PHP_INT_MAX]);
            }
        }

      //  $premiumLimit = ceil($limit / 2);
        $premiumLimit = 3;
        $normalLimit = $limit - $premiumLimit;

        $premiumQuery = (clone $baseQuery)->where('is_premium', true);
        $normalQuery = (clone $baseQuery)->where('is_premium', false);


        if ($request->filled('buildingType')) {
            $buildingType = Enum::check(PropertyType::class, $request->query('buildingType'));
            $premiumQuery->where('building_type', $buildingType);
            $normalQuery->where('building_type', $buildingType);
        }

        $premiumListings = $premiumQuery->inRandomOrder()->limit($premiumLimit)->get();
        $normalListings = $normalQuery->inRandomOrder()->limit($normalLimit)->get();

        $allListings = $premiumListings->merge($normalListings);

        if ($request->query()) {
            return PropertyListResource::collection($allListings);
        }

        $types = PropertyType::cases();
        $perTypeLimit = ceil($limit / count($types));
        $propertyGroups = [];

        foreach ($types as $type) {
            $typeQuery = (clone $baseQuery)->where('building_type', $type->value);

            $premium = (clone $typeQuery)->where('is_premium', true)->limit($perTypeLimit)->get();
            $remaining = $perTypeLimit - $premium->count();

            $all = $remaining > 0
                ? $premium->merge((clone $typeQuery)->where('is_premium', false)->limit($remaining)->get())
                : $premium;

            $propertyGroups[$type->label()] = PropertyListResource::collection($all);
        }

        return response()->json(['data' => $propertyGroups]);
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
    public function delete($id)
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


    public function makePremium(int $propertyId): JsonResponse
    {
        Property::query()->where('id', $propertyId)->update(['is_premium' => true]);
        return response()->json([
            "message" => "Property is premium now!",
            "data" => true]);
    }

    public function moveForward(int $propertyId): JsonResponse
    {
        Property::query()
            ->where('id', $propertyId)
            ->where('move_forward_count', '>', 0)
            ->update([
                'is_premium' => false,
                'is_move_forward' => true,
                'move_forward_count' => DB::raw('move_forward_count - 1'),
                'updated_at' => now()
            ]);

        return response()->json([
                "message" => "Property Move Forward Moved Successfully",
                "data" => true]
        );
    }

}
