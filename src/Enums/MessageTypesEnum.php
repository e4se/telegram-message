<?php

namespace E4se\TelegramMessage\Enums;

use BenSampo\Enum\Enum;

final class MessageTypesEnum extends Enum
{
    const warning = "warning";
    const strong = "strong";
    const link = "link";
    const text = "text";
}
