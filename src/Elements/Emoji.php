<?php

namespace E4se\TelegramMessage\Elements;

class Emoji extends Element
{
    /**
     * @param string|Element|array<int, string|Element>|null $value
     */
    public function __construct(
        public readonly string | Element | array | null $value,
        public readonly int | string $emoji_id
    )
    {
    }
}
