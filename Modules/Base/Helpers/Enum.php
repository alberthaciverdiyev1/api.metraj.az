<?php

namespace Modules\Base\Helpers;

class Enum
{

    public static function check($enum, $key)
    {
        $key = strtoupper($key);

        foreach ($enum::cases() as $case) {
            if ($case->name === $key) {
                return $case->value;
            }
        }
        abort(response()->json(['error' => "Invalid $enum value: $key"], 422));
    }
    public static function resolve($enum, $key){
        foreach ($enum::cases() as $case) {
            if ($case->value === $key) {
                return $case->label();
            }
        }
        abort(response()->json(['error' => "Invalid $enum value: $key"], 422));
    }
}
