<?php

namespace Modules\User\Http\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class FavoriteResource extends JsonResource
{
    public function toArray($request)
    {
        return parent::toArray($request);
    }
}
