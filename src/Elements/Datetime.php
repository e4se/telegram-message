<?php

namespace E4se\TelegramMessage\Elements;

class Datetime extends Element
{
    public function __construct(
        public readonly string | Element  $value,
        public readonly int  $datetime,
        public readonly string  $format,
    )
    {
    }
}
