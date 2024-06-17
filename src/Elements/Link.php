<?php

namespace E4se\TelegramMessage\Elements;

class Link extends Element
{
    public function __construct(
        public readonly string | Element  $value,
        public readonly string  $link,
    )
    {
    }
}
