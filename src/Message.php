<?php

namespace E4se\TelegramMessage;

use E4se\TelegramMessage\Enums\MessageTypesEnum;
use E4se\TelegramMessage\Facades\MessageFormatter;

class Message
{
    private $data = [];

    public function line(String $value = ""): self
    {
        return $this->text("\n" . $value);
    }

    public function strong(String $value): self
    {
        $this->data[] = [
            'type' => MessageTypesEnum::strong(),
            'value' => $value
        ];
        return $this;
    }

    public function link(String $value, String $link): self
    {
        $this->data[] = [
            'type' => MessageTypesEnum::link(),
            'value' => $value,
            'link' => $link
        ];
        return $this;
    }

    public function strongLink(String $value, String $link): self
    {
        $this->data[] = [
            'type' => MessageTypesEnum::strongLink(),
            'value' => $value,
            'link' => $link
        ];
        return $this;
    }

    public function text(String $value): self
    {
        $this->data[] = [
            'type' => MessageTypesEnum::text(),
            'value' => $value
        ];
        return $this;
    }

    public function warning(String $value): self
    {
        $this->data[] = [
            'type' => MessageTypesEnum::warning(),
            'value' => $value
        ];
        return $this;
    }

    public function image(String $value): self
    {
        return $this->link("⁠"⁠, $value);
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
        foreach ($this->data as $data) {
            $data['value'] = htmlspecialchars($data['value']);
            $message .= MessageFormatter::render($data['type'], $data);
        }
        return $message;
    }

    public function listItem(String $firstValue, String $secondValue): self
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


    public function __toString(): string
    {
        return $this->render();
    }
    
    public function when($condition, \Closure $closure, ?\Closure $default = null) :self {
        if ($condition) {
            return $closure($this) ?: $this;
        } else {
            return $default($this) ?: $this;
        }

        return $this;
    }
}
