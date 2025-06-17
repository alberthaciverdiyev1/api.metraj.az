<?php

namespace Modules\Price\Http\Entities;

use Database\Factories\PriceFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Property\Http\Entities\Property;

class Price extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'price',
        'currency',
        'property_id',
    ];

    public function property()
    {
        return $this->belongsTo(Property::class);
    }
    public static function newFactory ()
    {
        return PriceFactory::new();
    }
}
