<?php

namespace Modules\City\Http\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\City\Database\Factories\CityFactory;
use Modules\District\Http\Entities\District;

class City extends Model
{
    use SoftDeletes, HasFactory;

    protected $fillable = [
        'name',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    protected static function newFactory(): CityFactory
    {
        return CityFactory::new();
    }

    public function districts()
    {
        return $this->hasMany(District::class);
    }

}
