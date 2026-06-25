<?php

namespace E4se\TelegramMessage\Elements;

use E4se\TelegramMessage\Facades\MessageFormatter;

class Element implements \Stringable
{
    /**
     * @param string|Element|array<int, string|Element>|null $value
     */
    public function __construct(
        public readonly string | Element | array | null $value = '',
    )
    {
    }

    public function render(): string
    {
        return MessageFormatter::render($this);
    }

    public function __toString(): string
    {
        return self::renderValue($this->value);
    }

    /**
     * @param string|Element|array<int, string|Element>|null $value
     */
    public static function renderValue(string | Element | array | null $value): string
    {
        if ($value === null) {
            return '';
        }

        if ($value instanceof Element) {
            return $value->render();
        }

        if (is_array($value)) {
            return implode('', array_map(
                fn (string | Element | array | null $part): string => self::renderValue($part),
                $value
            ));
        }

        return htmlspecialchars($value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
    }
}
