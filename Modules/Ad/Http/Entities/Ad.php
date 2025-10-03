<?php

namespace Modules\Ad\Http\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\User\Http\Entities\User;

class Ad extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'ads';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'agency_id',
        'image',
        'deactive_date',
        'is_active',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'deactive_date' => 'datetime',
        'is_active' => 'boolean',
    ];

    /**
     * Get the agency user that owns the ad.
     */
    public function agency()
    {
        return $this->belongsTo(User::class, 'agency_id');
    }

    /**
     * Scope to get only active ads.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true)
                     ->where('deactive_date', '>', now());
    }

    /**
     * Scope to get ads expiring soon.
     */
    public function scopeExpiringSoon($query)
    {
        return $query->where('is_active', true)
                     ->where('deactive_date', '<=', now()->addDays(3))
                     ->where('deactive_date', '>', now());
    }
}
