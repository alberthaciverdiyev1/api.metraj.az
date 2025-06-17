<?php

namespace Modules\Feature\Http\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Request;

class FeatureResource extends JsonResource
{
    public function toArray(Request $request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name
        ];
    }
}
