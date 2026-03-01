<?php

namespace E4se\TelegramMessage\Elements;

class Emoji extends Element
{
    public function __construct(
        public readonly string | Element  $value,
        public readonly int  $emoji_id
    )
    {
    }
}
