<?php

namespace Modules\Nearby\Http\Entities;

use Database\Factories\NearbyFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Property\Http\Entities\Property;

class Nearby extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $table = 'nearby_objects';

    protected $fillable = [
        'name',
        'is_active'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_active' => 'boolean'
    ];

    public function properties()
    {
        return $this->belongsToMany(Property::class, 'nearby_property', 'nearby_id', 'property_id');
    }
    public static function newFactory ():NearbyFactory
    {
        return NearbyFactory::new();
    }}
