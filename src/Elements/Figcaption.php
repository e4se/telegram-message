<?php

namespace E4se\TelegramMessage\Elements;

class Figcaption extends Element
{
    /**
     * @param string|Element|array<int, string|Element>|null $value
     * @param string|Element|array<int, string|Element>|null $credit
     */
    public function __construct(
        public readonly string | Element | array | null $value,
        public readonly string | Element | array | null $credit = null,
    )
    {
    }
}
