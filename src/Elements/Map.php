<?php

namespace E4se\TelegramMessage\Elements;

class Map extends Element
{
    public function __construct(
        public readonly float | string $lat,
        public readonly float | string $long,
        public readonly int | string $zoom = 14,
        public readonly ?int $width = null,
        public readonly ?int $height = null,
    )
    {
        parent::__construct('');
    }
}
