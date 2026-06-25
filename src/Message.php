<?php

namespace E4se\TelegramMessage;

use E4se\TelegramMessage\Elements\Anchor;
use E4se\TelegramMessage\Elements\Animation;
use E4se\TelegramMessage\Elements\Audio;
use E4se\TelegramMessage\Elements\Blockquote;
use E4se\TelegramMessage\Elements\Checkbox;
use E4se\TelegramMessage\Elements\Code;
use E4se\TelegramMessage\Elements\Collage;
use E4se\TelegramMessage\Elements\Datetime;
use E4se\TelegramMessage\Elements\Details;
use E4se\TelegramMessage\Elements\Divider;
use E4se\TelegramMessage\Elements\Element;
use E4se\TelegramMessage\Elements\Emoji;
use E4se\TelegramMessage\Elements\EmojiImage;
use E4se\TelegramMessage\Elements\Figure;
use E4se\TelegramMessage\Elements\Footer;
use E4se\TelegramMessage\Elements\Heading;
use E4se\TelegramMessage\Elements\Italic;
use E4se\TelegramMessage\Elements\LineBreak;
use E4se\TelegramMessage\Elements\Link;
use E4se\TelegramMessage\Elements\ListBlock;
use E4se\TelegramMessage\Elements\Map as MapElement;
use E4se\TelegramMessage\Elements\Marked;
use E4se\TelegramMessage\Elements\MathematicalExpression;
use E4se\TelegramMessage\Elements\MathBlock;
use E4se\TelegramMessage\Elements\Paragraph;
use E4se\TelegramMessage\Elements\Photo;
use E4se\TelegramMessage\Elements\Preformatted;
use E4se\TelegramMessage\Elements\PullQuote;
use E4se\TelegramMessage\Elements\Reference;
use E4se\TelegramMessage\Elements\Slideshow;
use E4se\TelegramMessage\Elements\Spoiler;
use E4se\TelegramMessage\Elements\Strikethrough;
use E4se\TelegramMessage\Elements\Strong;
use E4se\TelegramMessage\Elements\Subscript;
use E4se\TelegramMessage\Elements\Superscript;
use E4se\TelegramMessage\Elements\Table;
use E4se\TelegramMessage\Elements\Text;
use E4se\TelegramMessage\Elements\Thinking;
use E4se\TelegramMessage\Elements\Underline;
use E4se\TelegramMessage\Elements\Video;
use E4se\TelegramMessage\Elements\VoiceNote;
use E4se\TelegramMessage\Elements\Warning;

class Message implements \Stringable
{
    /**
     * @var array<int, Element>
     */
    private array $data = [];

    /**
     * @param string|Element|array<int, string|Element>|null $value
     */
    public function line(string | Element | array | null $value = ""): self
    {
        return $this->text("\n")->text($value);
    }

    /**
     * @param string|Element|array<int, string|Element>|null $value
     */
    public function code(string | Element | array | null $value): self
    {
        return $this->addValueElement(Code::class, $value);
    }

    /**
     * @param string|Element|array<int, string|Element>|null $value
     */
    public function strong(string | Element | array | null $value): self
    {
        return $this->addValueElement(Strong::class, $value);
    }

    /**
     * @param string|Element|array<int, string|Element>|null $value
     */
    public function bold(string | Element | array | null $value): self
    {
        return $this->strong($value);
    }

    /**
     * @param string|Element|array<int, string|Element>|null $value
     */
    public function italic(string | Element | array | null $value): self
    {
        return $this->addValueElement(Italic::class, $value);
    }

    /**
     * @param string|Element|array<int, string|Element>|null $value
     */
    public function strikethrough(string | Element | array | null $value): self
    {
        return $this->addValueElement(Strikethrough::class, $value);
    }

    /**
     * @param string|Element|array<int, string|Element>|null $value
     */
    public function marked(string | Element | array | null $value): self
    {
        return $this->addValueElement(Marked::class, $value);
    }

    /**
     * @param string|Element|array<int, string|Element>|null $value
     */
    public function subscript(string | Element | array | null $value): self
    {
        return $this->addValueElement(Subscript::class, $value);
    }

    /**
     * @param string|Element|array<int, string|Element>|null $value
     */
    public function superscript(string | Element | array | null $value): self
    {
        return $this->addValueElement(Superscript::class, $value);
    }

    /**
     * @param string|Element|array<int, string|Element>|null $value
     */
    public function spoiler(string | Element | array | null $value): self
    {
        return $this->addValueElement(Spoiler::class, $value);
    }

    /**
     * @param string|Element|array<int, string|Element>|null $value
     */
    public function link(string | Element | array | null $value, string $link): self
    {
        $this->add(
            new Link(
                value: $value,
                link: $link
            )
        );
        return $this;
    }

    /**
     * @param string|Element|array<int, string|Element>|null $value
     */
    public function strongLink(string | Element | array | null $value, string $link): self
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

    /**
     * @param string|Element|array<int, string|Element>|null $value
     */
    public function text(string | Element | array | null $value): self
    {
        return $this->addValueElement(Text::class, $value);
    }

    /**
     * @param string|Element|array<int, string|Element>|null $value
     */
    public function warning(string | Element | array | null $value): self
    {
        return $this->addValueElement(Warning::class, $value);
    }

    /**
     * @param string|Element|array<int, string|Element>|null $value
     */
    public function underline(string | Element | array | null $value): self
    {
        return $this->addValueElement(Underline::class, $value);
    }

    public function anchor(string $name): self
    {
        $this->add(new Anchor($name));
        return $this;
    }

    /**
     * @param string|Element|array<int, string|Element>|null $value
     */
    public function reference(string | Element | array | null $value, string $name): self
    {
        $this->add(new Reference($value, $name));
        return $this;
    }

    public function image(string $value): self
    {
        $this->add(
            new Link(
                value: "⁠",
                link: $value
            )
        );
        
        return $this;
    }

    public function heading(string | Element | array | null $value, int $level = 1): self
    {
        $this->add(new Heading($value, $level));
        return $this;
    }

    public function paragraph(string | Element | array | null $value): self
    {
        return $this->addValueElement(Paragraph::class, $value);
    }

    public function pre(string | Element | array | null $value, ?string $language = null): self
    {
        $this->add(new Preformatted($value, $language));
        return $this;
    }

    public function footer(string | Element | array | null $value): self
    {
        return $this->addValueElement(Footer::class, $value);
    }

    public function divider(): self
    {
        $this->add(new Divider());
        return $this;
    }

    public function br(): self
    {
        $this->add(new LineBreak());
        return $this;
    }

    public function checkbox(bool $checked = false): self
    {
        $this->add(new Checkbox($checked));
        return $this;
    }

    public function math(string | Element | array | null $value): self
    {
        return $this->addValueElement(MathematicalExpression::class, $value);
    }

    public function mathBlock(string | Element | array | null $value): self
    {
        return $this->addValueElement(MathBlock::class, $value);
    }

    public function blockquote(string | Element | array | null $value, string | Element | array | null $credit = null): self
    {
        $this->add(new Blockquote($value, $credit));
        return $this;
    }

    public function pullQuote(string | Element | array | null $value, string | Element | array | null $credit = null): self
    {
        $this->add(new PullQuote($value, $credit));
        return $this;
    }

    /**
     * @param array<int, \E4se\TelegramMessage\Elements\ListItem|string|Element|array<int, string|Element>> $items
     */
    public function richList(array $items, bool $ordered = false, ?int $start = null, ?string $type = null, bool $reversed = false): self
    {
        $this->add(new ListBlock($items, $ordered, $start, $type, $reversed));
        return $this;
    }

    /**
     * @param array<int, \E4se\TelegramMessage\Elements\ListItem|string|Element|array<int, string|Element>> $items
     */
    public function unorderedList(array $items): self
    {
        return $this->richList($items);
    }

    /**
     * @param array<int, \E4se\TelegramMessage\Elements\ListItem|string|Element|array<int, string|Element>> $items
     */
    public function orderedList(array $items, ?int $start = null, ?string $type = null, bool $reversed = false): self
    {
        return $this->richList($items, true, $start, $type, $reversed);
    }

    public function photo(string $src, bool $hasSpoiler = false, ?string $alt = null): self
    {
        $this->add(new Photo($src, $hasSpoiler, $alt));
        return $this;
    }

    public function video(string $src, bool $hasSpoiler = false): self
    {
        $this->add(new Video($src, $hasSpoiler));
        return $this;
    }

    public function animation(string $src, bool $hasSpoiler = false): self
    {
        $this->add(new Animation($src, $hasSpoiler));
        return $this;
    }

    public function audio(string $src): self
    {
        $this->add(new Audio($src));
        return $this;
    }

    public function voiceNote(string $src): self
    {
        $this->add(new VoiceNote($src));
        return $this;
    }

    public function map(float | string $lat, float | string $long, int | string $zoom = 14, ?int $width = null, ?int $height = null): self
    {
        $this->add(new MapElement($lat, $long, $zoom, $width, $height));
        return $this;
    }

    public function figure(Element $block, string | Element | array | null $caption = null, string | Element | array | null $credit = null): self
    {
        $this->add(new Figure($block, $caption, $credit));
        return $this;
    }

    /**
     * @param array<int, Element> $blocks
     */
    public function collage(array $blocks, string | Element | array | null $caption = null, string | Element | array | null $credit = null): self
    {
        $this->add(new Collage($blocks, $caption, $credit));
        return $this;
    }

    /**
     * @param array<int, Element> $blocks
     */
    public function slideshow(array $blocks, string | Element | array | null $caption = null, string | Element | array | null $credit = null): self
    {
        $this->add(new Slideshow($blocks, $caption, $credit));
        return $this;
    }

    public function details(string | Element | array | null $summary, string | Element | array | null $value, bool $open = false): self
    {
        $this->add(new Details($summary, $value, $open));
        return $this;
    }

    /**
     * @param array<int, \E4se\TelegramMessage\Elements\TableRow|array<int, \E4se\TelegramMessage\Elements\TableCell|string|Element|array<int, string|Element>>> $rows
     */
    public function table(array $rows, bool $bordered = false, bool $striped = false, string | Element | array | null $caption = null): self
    {
        $this->add(new Table($rows, $bordered, $striped, $caption));
        return $this;
    }

    public function thinking(string | Element | array | null $value): self
    {
        return $this->addValueElement(Thinking::class, $value);
    }

    public function add(Element $element): self
    {
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

    public function render(): string
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

    public function listItem(string | Element $firstValue, string | Element $secondValue): self
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

    public function emoji(string | Element | array | null $value, int | string $emoji_id): self
    {
        $this->add(
            new Emoji(
                value: $value,
                emoji_id: $emoji_id
            )
        );

        return $this;
    }

    public function emojiImage(int | string $emojiId, string $alt): self
    {
        $this->add(new EmojiImage($emojiId, $alt));
        return $this;
    }

    public function datetime(string | Element | array | null $value, int $datetime, string $format): self
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

    public function toInputRichMessage(bool $isRtl = false, bool $skipEntityDetection = false): array
    {
        $message = ['html' => $this->render()];

        if ($isRtl) {
            $message['is_rtl'] = true;
        }

        if ($skipEntityDetection) {
            $message['skip_entity_detection'] = true;
        }

        return $message;
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

    /**
     * @param class-string<Element> $elementClass
     * @param string|Element|array<int, string|Element>|null $value
     */
    private function addValueElement(string $elementClass, string | Element | array | null $value): self
    {
        $this->add(new $elementClass($value));
        return $this;
    }
}
