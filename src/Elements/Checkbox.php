<?php

namespace E4se\TelegramMessage\Elements;

class Checkbox extends Element
{
    public function __construct(
        public readonly bool $checked = false,
    )
    {
        parent::__construct('');
    }
}
