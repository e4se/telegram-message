<?php

namespace E4se\TelegramMessage\Elements;

class PullQuote extends Element
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
