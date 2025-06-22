<?php

namespace Modules\Property\Http\Entities;

use Database\Factories\PropertyFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Price\Http\Entities\Price;
use Modules\Property\Http\Traits\PropertyAccessors;
use Modules\Property\Http\Traits\PropertyRelations;

class Property extends Model
{
    use SoftDeletes, HasFactory,PropertyRelations,PropertyAccessors;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'properties';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'add_no',
        'slug',
        'town_id',
        'subway_id',
        'district_id',
        'city_id',
        'address',
        'add_type',
        'property_condition',
        'number_of_floors',
        'number_of_rooms',
        'floor_located',
        'area',
        'field_area',
        'advertiser',
        'advertiser_name',
        'phone_1',
        'phone_2',
        'phone_3',
        'phone_4',
        'mail',
        'description',
        'in_credit',
        'document',
        'note_to_admin',
        'building_type',
        'has_video',
        'google_map_location',
        'is_active',
        'is_premium',
        'user_id',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'in_credit' => 'boolean',
        'has_video' => 'boolean',
        'is_active' => 'boolean',
        'is_premium' => 'boolean',
        'deleted_at' => 'datetime',
    ];



    public function firstImage()
    {
        return $this->morphOne(\Modules\Media\Http\Entities\Media::class, 'imageable')
            ->where('type', 'image')
            ->orderBy('created_at', 'asc');
    }

    public static function newFactory(): PropertyFactory
    {
        return PropertyFactory::new();
    }
}
