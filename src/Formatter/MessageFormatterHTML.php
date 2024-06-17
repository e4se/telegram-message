<?php

namespace E4se\TelegramMessage\Formatter;

use E4se\TelegramMessage\Elements\Code;
use E4se\TelegramMessage\Elements\Element;
use E4se\TelegramMessage\Elements\Link;
use E4se\TelegramMessage\Elements\Strong;
use E4se\TelegramMessage\Elements\Underline;
use E4se\TelegramMessage\Elements\Warning;
use E4se\TelegramMessage\Enums\MessageTypesEnum;

class MessageFormatterHTML implements MessageFormatterInterface
{
    public function getFormat(): string
    {
        return "HTML";
    }

    public function render(Element $element): string
    {
        return match (get_class($element)) {
            Warning::class => "<b>❗️❗️❗️{$element}❗️❗️❗️ </b>",
            Link::class => "<a href='{$element->link}'>{$element}</a> ",
            Strong::class => "<b>{$element}</b>",
            Code::class => "<code>{$element}</code>",
            Underline::class => "<u>{$element}</u>",
            default => "{$element}"
        };
    }
}
