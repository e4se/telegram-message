<?php

namespace E4se\TelegramMessage\Elements;

class Details extends Element
{
    /**
     * @param string|\Stringable|array<int, string|\Stringable>|null $summary
     * @param string|\Stringable|array<int, string|\Stringable>|null $value
     */
    public function __construct(
        public readonly string | \Stringable | array | null $summary,
        public readonly string | \Stringable | array | null $value,
        public readonly bool $open = false,
    )
    {
    }
}
