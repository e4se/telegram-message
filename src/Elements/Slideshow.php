<?php

namespace E4se\TelegramMessage\Elements;

use E4se\TelegramMessage\Message;

class Slideshow extends Element
{
    /**
     * @param string|\Stringable|array<int, Element>|null $value
     */
    public function __construct(
        string | \Stringable | array | null $value
    )
    {
        parent::__construct(is_array($value) ? self::messageFromBlocks($value) : $value);
    }

    /**
     * @param array<int, Element> $blocks
     */
    private static function messageFromBlocks(array $blocks): Message
    {
        $message = new Message();

        foreach ($blocks as $block) {
            $message->add($block);
        }

        return $message;
    }
}
