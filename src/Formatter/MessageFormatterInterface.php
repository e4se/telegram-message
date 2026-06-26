<?php

namespace E4se\TelegramMessage\Formatter;

use E4se\TelegramMessage\Elements\Element;

interface MessageFormatterInterface
{
    public function getFormat(): string;
    public function render(Element $element): string;
}
