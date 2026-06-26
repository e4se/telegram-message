<?php

namespace E4se\TelegramMessage\Elements;

class ListItem extends Element
{
    /**
     * @param string|\Stringable|array<int, string|\Stringable>|null $value
     */
    public function __construct(
        public readonly string | \Stringable | array | null $value,
        public readonly ?int $valueNumber = null,
        public readonly ?string $type = null,
    )
    {
        ListBlock::assertListType($type);
    }
}
