<?php

namespace Modules\Media\Http\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Request;

class MediaResource extends JsonResource
{

    public function toArray(Request $request)
    {
        return [
            'type' => $this->type,
            'path' => $this->path
        ];
    }
}
