<?php

namespace E4se\TelegramMessage\Formatter;

use E4se\TelegramMessage\Enums\MessageTypesEnum;

class MessageFormatterHTML implements MessageFormatterInterface
{
    public function getFormat(): string
    {
        return "HTML";
    }

    public function render(MessageTypesEnum $type, array $data): string
    {
        return match ($type->value) {
            MessageTypesEnum::warning => "❗️❗️❗️" . $data['value'] . "❗️❗️❗️ ",
            MessageTypesEnum::link => "<a href='{$data['link']}'>{$data['value']}</a> ",
            MessageTypesEnum::strong => "<b>" . $data['value'] . "</b>",
            default => $data['value']
        };
    }
}
