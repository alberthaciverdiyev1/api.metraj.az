<?php

namespace Modules\User\Http\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Property\Http\Entities\Property;

class Favorite extends Model
{
    use SoftDeletes;
    protected $table = 'user_favorites';

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function property()
    {
        return $this->belongsTo(Property::class);
    }
}
