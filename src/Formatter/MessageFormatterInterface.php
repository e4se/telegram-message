<?php

namespace E4se\TelegramMessage\Formatter;

use E4se\TelegramMessage\Elements\Element;
use E4se\TelegramMessage\Enums\MessageTypesEnum;

interface MessageFormatterInterface
{
    public function getFormat(): string;
    public function render(Element $type): string;
}
