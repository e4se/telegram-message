<?php

namespace E4se\TelegramMessage\Elements;

class Heading extends Element
{
    /**
     * @param string|Element|array<int, string|Element>|null $value
     */
    public function __construct(
        public readonly string | Element | array | null $value,
        public readonly int $level = 1,
    )
    {
        if ($level < 1 || $level > 6) {
            throw new \InvalidArgumentException('Heading level must be between 1 and 6.');
        }
    }
}
