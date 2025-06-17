<?php

namespace Modules\Feature\Http\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Feature\Database\Factories\FeatureFactory;
use Modules\Property\Http\Entities\Property;

class Feature extends Model
{
    use HasFactory;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'features';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'slug',
        'is_active',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_active' => 'boolean',
    ];
    public function properties()
    {
        return $this->belongsToMany(Property::class, 'feature_property', 'feature_id', 'property_id');
    }
    public static function newFactory ()
    {
        return FeatureFactory::new();
    }
}
