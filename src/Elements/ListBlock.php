<?php

namespace E4se\TelegramMessage\Elements;

class ListBlock extends Element
{
    /**
     * @param array<int, ListItem|string|Element|array<int, string|Element>> $items
     */
    public function __construct(
        public readonly array $items,
        public readonly bool $ordered = false,
        public readonly ?int $start = null,
        public readonly ?string $type = null,
        public readonly bool $reversed = false,
    )
    {
        parent::__construct('');
        self::assertListType($type);
    }

    public static function assertListType(?string $type): void
    {
        if ($type !== null && !in_array($type, ['a', 'A', 'i', 'I', '1'], true)) {
            throw new \InvalidArgumentException('List type must be one of: a, A, i, I, 1.');
        }
    }
}
