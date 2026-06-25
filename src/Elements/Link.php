<?php

namespace E4se\TelegramMessage\Elements;

class Link extends Element
{
    /**
     * @param string|Element|array<int, string|Element>|null $value
     */
    public function __construct(
        public readonly string | Element | array | null $value,
        public readonly string $link,
    )
    {
    }
}
