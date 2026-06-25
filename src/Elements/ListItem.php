<?php

namespace E4se\TelegramMessage\Elements;

class ListItem extends Element
{
    /**
     * @param string|Element|array<int, string|Element>|null $value
     */
    public function __construct(
        public readonly string | Element | array | null $value,
        public readonly ?int $valueNumber = null,
        public readonly ?string $type = null,
        public readonly bool $hasCheckbox = false,
        public readonly bool $isChecked = false,
    )
    {
        ListBlock::assertListType($type);
    }
}
