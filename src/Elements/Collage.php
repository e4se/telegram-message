<?php

namespace E4se\TelegramMessage\Elements;

class Collage extends Element
{
    /**
     * @param array<int, Element> $blocks
     * @param string|Element|array<int, string|Element>|null $caption
     * @param string|Element|array<int, string|Element>|null $credit
     */
    public function __construct(
        public readonly array $blocks,
        public readonly string | Element | array | null $caption = null,
        public readonly string | Element | array | null $credit = null,
    )
    {
        parent::__construct('');
    }
}
