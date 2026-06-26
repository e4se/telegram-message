<?php

namespace E4se\TelegramMessage\Elements;

class Heading extends Element
{
    /**
     * @param string|\Stringable|array<int, string|\Stringable>|null $value
     */
    public function __construct(
        public readonly string | \Stringable | array | null $value,
        public readonly int $level = 1,
    )
    {
        if ($level < 1 || $level > 6) {
            throw new \InvalidArgumentException('Heading level must be between 1 and 6.');
        }
    }
}
