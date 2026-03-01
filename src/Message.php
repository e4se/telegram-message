<?php

namespace E4se\TelegramMessage;

use E4se\TelegramMessage\Elements\Code;
use E4se\TelegramMessage\Elements\Datetime;
use E4se\TelegramMessage\Elements\Element;
use E4se\TelegramMessage\Elements\Emoji;
use E4se\TelegramMessage\Elements\Link;
use E4se\TelegramMessage\Elements\Strong;
use E4se\TelegramMessage\Elements\Text;
use E4se\TelegramMessage\Elements\Underline;
use E4se\TelegramMessage\Elements\Warning;

class Message implements \Stringable
{

    private $data = [];

    public function line(String | Element $value = ""): self
    {
        return $this->text("\n")->text($value);
    }

    public function code(String | Element $value): self
    {
        $this->add(
            new Code(
                value: $value
            )
        );
        return $this;
    }

    public function strong(String | Element $value): self
    {
        $this->add(
            new Strong(
                value: $value
            )
        );
        return $this;
    }

    public function link(String | Element $value, String $link): self
    {
        $this->add(
            new Link(
                value: $value,
                link: $link
            )
        );
        return $this;
    }

    public function strongLink(String | Element $value, String $link): self
    {
        $this->add(
            new Strong(
                value: new Link(
                    value: $value,
                    link: $link
                )
            )
        );

        return $this;
    }

    public function text(String | Element $value): self
    {
        $this->add(
            new Text(
                value: $value
            )
        );
        return $this;
    }

    public function warning(String | Element $value): self
    {
        $this->add(
            new Warning(
                value: $value
            )
        );
        return $this;
    }

    public function underline(String | Element $value): self
    {
        $this->add(
            new Underline(
                value: $value
            )
        );
        return $this;
    }

    public function image(String $value): self
    {
        $this->add(
            new Link(
                value: "⁠",
                link: $value
            )
        );
        
        return $this;
    }

    public function add(Element $element): self{
        $this->data[] = $element;
        return $this;
    }

    public function merge(self $message): self
    {
        $this->data = array_merge($this->data, $message->data);
        return $this;
    }

    public static function create(): self
    {
        return new Message();
    }

    public function render(): String
    {
        $message = "";
        foreach ($this->data as $element) {
            $message .= $element->render();
        }
        return $message;
    }

    public function each(array $values, ?\Closure $closure = null) : self {
        foreach ($values as $key => $value) {
            $this->when($closure, fn () => $closure($this, $value, $key), fn () => $this->line($value));
        }
        return $this;
    }

    public function listItem(String | Element $firstValue, String | Element $secondValue): self
    {
        return $this->line($firstValue)->text(": ")->strong($secondValue);
    }

    public function list(array $values): self
    {
        foreach ($values as $left => $right) {
            $this->listItem($left, $right);
        }
        return $this;
    }

    public function emoji(String $value, int $emoji_id): self
    {
        $this->add(
            new Emoji(
                value: $value,
                emoji_id: $emoji_id
            )
        );

        return $this;
    }

    public function datetime(String $value, int $datetime, string $format): self
    {
        $this->add(
            new Datetime(
                value: $value,
                datetime: $datetime,
                format: $format
            )
        );

        return $this;
    }


    public function __toString(): string
    {
        return $this->render();
    }

    public function when($condition, \Closure $closure, ?\Closure $default = null) :self {
        if ($condition) {
            return $closure($this) ?: $this;
        } elseif ($default) {
            return $default($this) ?: $this;
        }

        return $this;
    }
}
