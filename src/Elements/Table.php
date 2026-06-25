<?php

namespace E4se\TelegramMessage\Elements;

class Table extends Element
{
    /**
     * @param array<int, TableRow|array<int, TableCell|string|Element|array<int, string|Element>>> $rows
     * @param string|Element|array<int, string|Element>|null $caption
     */
    public function __construct(
        public readonly array $rows,
        public readonly bool $bordered = false,
        public readonly bool $striped = false,
        public readonly string | Element | array | null $caption = null,
    )
    {
        parent::__construct('');
    }
}
