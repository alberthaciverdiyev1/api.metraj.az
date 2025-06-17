<?php

namespace Modules\Property\Http\Traits;

trait PropertyAccessors
{
    public function getMediaAttribute(): \Illuminate\Database\Eloquent\Collection|\Illuminate\Support\Collection
    {
        $media = $this->media()->get();

        if ($media->isEmpty()) {
            return collect([
                (object)[
                    'path' => 'https://static.vecteezy.com/system/resources/previews/004/640/986/non_2x/tower-building-illustration-isolated-on-white-background-vector.jpg',
                    'type' => 'image',
                ]
            ]);
        }

        return $media;
    }
}
