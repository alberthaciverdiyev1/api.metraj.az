<?php

namespace Modules\Seo\Http\Entities;

use Database\Factories\SeoFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Seo extends Model
{
    use SoftDeletes,HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'seo';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'description',
        'meta_tags',
        'other_codes',
        'page',
        'user_id',
        'is_active'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'deleted_at' => 'datetime',
    ];

    public static function newFactory():SeoFactory
    {
        return SeoFactory::new();
    }

}
