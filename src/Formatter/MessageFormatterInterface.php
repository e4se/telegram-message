<?php

namespace E4se\TelegramMessage\Formatter;

use E4se\TelegramMessage\Enums\MessageTypesEnum;

interface MessageFormatterInterface
{
    public function getFormat(): string;
    public function render(MessageTypesEnum $type, array $data): string;
}
