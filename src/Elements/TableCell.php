<?php

namespace E4se\TelegramMessage\Elements;

class TableCell extends Element
{
    /**
     * @param string|\Stringable|array<int, string|\Stringable>|null $value
     */
    public function __construct(
        public readonly string | \Stringable | array | null $value = null,
        public readonly bool $isHeader = false,
        public readonly ?int $colspan = null,
        public readonly ?int $rowspan = null,
        public readonly ?string $align = null,
        public readonly ?string $valign = null,
    )
    {
        if ($align !== null && !in_array($align, ['left', 'center', 'right'], true)) {
            throw new \InvalidArgumentException('Table cell align must be one of: left, center, right.');
        }

        if ($valign !== null && !in_array($valign, ['top', 'middle', 'bottom'], true)) {
            throw new \InvalidArgumentException('Table cell valign must be one of: top, middle, bottom.');
        }
    }
}
