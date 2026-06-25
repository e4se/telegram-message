<?php

namespace E4se\TelegramMessage\Elements;

class Figure extends Element
{
    /**
     * @param string|Element|array<int, string|Element>|null $caption
     * @param string|Element|array<int, string|Element>|null $credit
     */
    public function __construct(
        public readonly Element $block,
        public readonly string | Element | array | null $caption = null,
        public readonly string | Element | array | null $credit = null,
    )
    {
        parent::__construct('');
    }
}
