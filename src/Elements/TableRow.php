<?php

namespace E4se\TelegramMessage\Elements;

use E4se\TelegramMessage\Message;

class TableRow extends Element
{
    /**
     * @param string|\Stringable|array<int, TableCell|string|\Stringable|array<int, string|\Stringable>>|null $value
     */
    public function __construct(
        string | \Stringable | array | null $value,
    )
    {
        parent::__construct(is_array($value) ? self::messageFromCells($value) : $value);
    }

    /**
     * @param array<int, TableCell|string|\Stringable|array<int, string|\Stringable>> $cells
     */
    private static function messageFromCells(array $cells): Message
    {
        $message = new Message();

        foreach ($cells as $cell) {
            $message->add($cell instanceof TableCell ? $cell : new TableCell($cell));
        }

        return $message;
    }
}
