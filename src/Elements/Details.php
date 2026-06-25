<?php

namespace E4se\TelegramMessage\Elements;

class Details extends Element
{
    /**
     * @param string|Element|array<int, string|Element>|null $summary
     * @param string|Element|array<int, string|Element>|null $value
     */
    public function __construct(
        public readonly string | Element | array | null $summary,
        public readonly string | Element | array | null $value,
        public readonly bool $open = false,
    )
    {
    }
}
