<?php

namespace E4se\TelegramMessage\Elements;

class Anchor extends Element
{
    public function __construct(
        public readonly string $name,
    )
    {
        parent::__construct('');
    }
}
