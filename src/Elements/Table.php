<?php

namespace E4se\TelegramMessage\Elements;

use E4se\TelegramMessage\Message;

class Table extends Element
{
    public readonly bool $bordered;
    public readonly bool $striped;

    /**
     * @param string|\Stringable|array<int, TableRow|array<int, TableCell|string|\Stringable|array<int, string|\Stringable>>>|null $value
     */
    public function __construct(
        string | \Stringable | array | null $value,
        bool $bordered = false,
        bool $striped = false
    )
    {
        parent::__construct(is_array($value) ? self::messageFromRows($value) : $value);
        $this->bordered = $bordered;
        $this->striped = $striped;
    }

    /**
     * @param array<int, TableRow|array<int, TableCell|string|\Stringable|array<int, string|\Stringable>>> $rows
     */
    private static function messageFromRows(array $rows): Message
    {
        $message = new Message();

        foreach ($rows as $row) {
            $message->add($row instanceof TableRow ? $row : new TableRow($row));
        }

        return $message;
    }
}
