<?php

namespace Modules\Property\Http\Traits;

use Modules\Feature\Http\Entities\Feature;
use Modules\Nearby\Http\Entities\Nearby;
use Modules\Price\Http\Entities\Price;

trait PropertyRelations
{
    public function city()
    {
        return $this->belongsTo(\Modules\City\Http\Entities\City::class);
    }

    public function town()
    {
        return $this->belongsTo(\Modules\Town\Http\Entities\Town::class);
    }

    public function district()
    {
        return $this->belongsTo(\Modules\District\Http\Entities\District::class);
    }

    public function subway()
    {
        return $this->belongsTo(\Modules\Base\Http\Entities\Subway::class);
    }

    public function user()
    {
        return $this->belongsTo(\Modules\User\Http\Entities\User::class);
    }

    public function realtor()
    {
        return $this->belongsTo(\Modules\User\Http\Entities\User::class, 'realtor_id');
    }

    public function media()
    {
        return $this->morphMany(\Modules\Media\Http\Entities\Media::class, 'imageable');
    }
    public function prices()
    {
        return $this->hasMany(Price::class);
    }
    public function features()
    {
        return $this->belongsToMany(Feature::class, 'feature_property', 'property_id', 'feature_id');
    }
    public function nearbyObjects()
    {
        return $this->belongsToMany(Nearby::class, 'nearby_property', 'property_id', 'nearby_id');
    }
}
