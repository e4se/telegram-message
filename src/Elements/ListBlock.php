<?php

namespace E4se\TelegramMessage\Elements;

use E4se\TelegramMessage\Message;

class ListBlock extends Element
{
    public readonly bool $ordered;
    public readonly ?int $start;
    public readonly ?string $type;
    public readonly bool $reversed;

    /**
     * @param string|\Stringable|array<int, ListItem|string|\Stringable|array<int, string|\Stringable>>|null $value
     */
    public function __construct(
        string | \Stringable | array | null $value,
        bool $ordered = false,
        ?int $start = null,
        ?string $type = null,
        bool $reversed = false,
    )
    {
        parent::__construct(is_array($value) ? self::messageFromItems($value) : $value);
        $this->ordered = $ordered;
        $this->start = $start;
        $this->type = $type;
        $this->reversed = $reversed;
        self::assertListType($type);
    }

    public static function assertListType(?string $type): void
    {
        if ($type !== null && !in_array($type, ['a', 'A', 'i', 'I', '1'], true)) {
            throw new \InvalidArgumentException('List type must be one of: a, A, i, I, 1.');
        }
    }

    /**
     * @param array<int, ListItem|string|\Stringable|array<int, string|\Stringable>> $items
     */
    private static function messageFromItems(array $items): Message
    {
        $message = new Message();

        foreach ($items as $item) {
            $message->add($item instanceof ListItem ? $item : new ListItem($item));
        }

        return $message;
    }
}
