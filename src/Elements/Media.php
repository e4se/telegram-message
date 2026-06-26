<?php

namespace E4se\TelegramMessage\Elements;

abstract class Media extends Element
{
    public function __construct(
        public readonly string $src,
        public readonly bool $hasSpoiler = false,
    )
    {
        parent::__construct('');
    }
}
