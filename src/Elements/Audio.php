<?php

namespace E4se\TelegramMessage\Elements;

class Audio extends Element
{
    public function __construct(
        public readonly string $src,
    )
    {
        parent::__construct('');
    }
}
