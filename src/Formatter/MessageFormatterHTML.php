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
            MessageTypesEnum::warning => "<b>❗️❗️❗️" . $data['value'] . "❗️❗️❗️ </b>",
            MessageTypesEnum::link => "<a href='{$data['link']}'>{$data['value']}</a> ",
            MessageTypesEnum::strong => "<b>" . $data['value'] . "</b>",
            MessageTypesEnum::strongLink => "<b><a href='{$data['link']}'>{$data['value']}</a></b>",
            default => $data['value']
        };
    }
}
