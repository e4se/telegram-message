<?php

namespace E4se\TelegramMessage\Elements;

class TableRow extends Element
{
    /**
     * @param array<int, TableCell|string|Element|array<int, string|Element>> $cells
     */
    public function __construct(
        public readonly array $cells,
    )
    {
        parent::__construct('');
    }
}
