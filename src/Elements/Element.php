<?php

namespace E4se\TelegramMessage\Elements;

use E4se\TelegramMessage\Facades\MessageFormatter;

class Element implements \Stringable
{
    public function __construct(
        public readonly string | Element  $value,
    )
    {
    }

    public function render(): string
    {
        return MessageFormatter::render($this);
    }

    public function __toString(): string
    {
        if($this->value instanceof Element){
            return $this->value->render();
        }
        return htmlspecialchars($this->value);
    }
}
