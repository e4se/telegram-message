<?php

namespace E4se\TelegramMessage\Elements;

class Photo extends Media
{
    public function __construct(
        string $src,
        bool $hasSpoiler = false,
        public readonly ?string $alt = null,
    )
    {
        parent::__construct($src, $hasSpoiler);
    }
}
