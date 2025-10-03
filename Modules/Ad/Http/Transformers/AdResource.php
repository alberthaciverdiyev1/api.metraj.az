<?php

namespace Modules\Ad\Http\Transformers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AdResource extends JsonResource
{
    /**
     * Transform the resource into an arrays.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'agency_id' => $this->agency_id,
            'agency_name' => $this->agency->name ?? null,
            'image' => $this->image,
            'deactive_date' => $this->deactive_date,
            'is_active' => $this->is_active,
            'is_expired' => $this->deactive_date < now(),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
