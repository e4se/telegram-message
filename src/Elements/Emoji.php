<?php

namespace E4se\TelegramMessage\Elements;

class Emoji extends Element
{
    /**
     * @param string|\Stringable|array<int, string|\Stringable>|null $value
     */
    public function __construct(
        public readonly string | \Stringable | array | null $value,
        public readonly int | string $emoji_id
    )
    {
    }
}
