<?php

namespace E4se\TelegramMessage\Elements;

class Link extends Element
{
    /**
     * @param string|\Stringable|array<int, string|\Stringable>|null $value
     */
    public function __construct(
        public readonly string | \Stringable | array | null $value,
        public readonly string $link,
    )
    {
    }
}
