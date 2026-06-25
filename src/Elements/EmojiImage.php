<?php

namespace E4se\TelegramMessage\Elements;

class EmojiImage extends Photo
{
    public function __construct(
        int | string $emojiId,
        string $alt,
    )
    {
        parent::__construct('tg://emoji?id=' . $emojiId, false, $alt);
    }
}
