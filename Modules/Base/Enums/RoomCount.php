<?php

namespace Modules\Base\Enums;

enum RoomCount: string
{
    case ONE_BEDROOM = '0x001';
    case TWO_BEDROOM = '0x002';
    case THREE_BEDROOM = '0x003';
    case FOUR_BEDROOM = '0x004';
    case FIVE_BEDROOM = '0x005';
    case SIX_BEDROOM = '0x006';
    case SEVEN_BEDROOM = '0x007';
    case EIGHT_BEDROOM = '0x008';
    case NINE_BEDROOM = '0x009';
    case TEN_BEDROOM = '0x00A';
    case ELEVEN_BEDROOM = '0x00B';
    case TWELVE_BEDROOM = '0x00C';
    case THIRTEEN_BEDROOM = '0x00D';
    case FOURTEEN_BEDROOM = '0x00E';
    case FIFTEEN_BEDROOM = '0x00F';
    case SIXTEEN_BEDROOM = '0x010';
    case SEVENTEEN_BEDROOM = '0x011';
    case EIGHTEEN_BEDROOM = '0x012';
    case NINETEEN_BEDROOM = '0x013';
    case TWENTY_BEDROOM = '0x014';

    public function label(): string
    {
        return match ($this) {
            RoomCount::ONE_BEDROOM => __('One Bedroom'),
            RoomCount::TWO_BEDROOM => __('Two Bedroom'),
            RoomCount::THREE_BEDROOM => __('Three Bedroom'),
            RoomCount::FOUR_BEDROOM => __('Four Bedroom'),
            RoomCount::FIVE_BEDROOM => __('Five Bedroom'),
            RoomCount::SIX_BEDROOM => __('Six Bedroom'),
            RoomCount::SEVEN_BEDROOM => __('Seven Bedroom'),
            RoomCount::EIGHT_BEDROOM => __('Eight Bedroom'),
            RoomCount::NINE_BEDROOM => __('Nine Bedroom'),
            RoomCount::TEN_BEDROOM => __('Ten Bedroom'),
            RoomCount::ELEVEN_BEDROOM => __('Eleven Bedroom'),
            RoomCount::TWELVE_BEDROOM => __('Twelve Bedroom'),
            RoomCount::THIRTEEN_BEDROOM => __('Thirteen Bedroom'),
            RoomCount::FOURTEEN_BEDROOM => __('Fourteen Bedroom'),
            RoomCount::FIFTEEN_BEDROOM => __('Fifteen Bedroom'),
            RoomCount::SIXTEEN_BEDROOM => __('Sixteen Bedroom'),
            RoomCount::SEVENTEEN_BEDROOM => __('Seventeen Bedroom'),
            RoomCount::EIGHTEEN_BEDROOM => __('Eighteen Bedroom'),
            RoomCount::NINETEEN_BEDROOM => __('Nineteen Bedroom'),
            RoomCount::TWENTY_BEDROOM => __('Twenty Bedroom'),
        };
    }

    public function value(): string
    {
        return $this->value;
    }
}

