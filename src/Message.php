<?php

namespace E4se\TelegramMessage;

use E4se\TelegramMessage\Elements\Anchor;
use E4se\TelegramMessage\Elements\Animation;
use E4se\TelegramMessage\Elements\Audio;
use E4se\TelegramMessage\Elements\Blockquote;
use E4se\TelegramMessage\Elements\Caption;
use E4se\TelegramMessage\Elements\Checkbox;
use E4se\TelegramMessage\Elements\Code;
use E4se\TelegramMessage\Elements\Collage;
use E4se\TelegramMessage\Elements\Credit;
use E4se\TelegramMessage\Elements\Datetime;
use E4se\TelegramMessage\Elements\Details;
use E4se\TelegramMessage\Elements\Divider;
use E4se\TelegramMessage\Elements\Element;
use E4se\TelegramMessage\Elements\Emoji;
use E4se\TelegramMessage\Elements\Figure;
use E4se\TelegramMessage\Elements\Footer;
use E4se\TelegramMessage\Elements\Heading;
use E4se\TelegramMessage\Elements\Italic;
use E4se\TelegramMessage\Elements\LineBreak;
use E4se\TelegramMessage\Elements\Link;
use E4se\TelegramMessage\Elements\ListBlock;
use E4se\TelegramMessage\Elements\ListItem;
use E4se\TelegramMessage\Elements\Map as MapElement;
use E4se\TelegramMessage\Elements\Marked;
use E4se\TelegramMessage\Elements\MathematicalExpression;
use E4se\TelegramMessage\Elements\MathBlock;
use E4se\TelegramMessage\Elements\Paragraph;
use E4se\TelegramMessage\Elements\Photo;
use E4se\TelegramMessage\Elements\Preformatted;
use E4se\TelegramMessage\Elements\PreformattedCode;
use E4se\TelegramMessage\Elements\PullQuote;
use E4se\TelegramMessage\Elements\Reference;
use E4se\TelegramMessage\Elements\Slideshow;
use E4se\TelegramMessage\Elements\Spoiler;
use E4se\TelegramMessage\Elements\Strikethrough;
use E4se\TelegramMessage\Elements\Strong;
use E4se\TelegramMessage\Elements\Subscript;
use E4se\TelegramMessage\Elements\Superscript;
use E4se\TelegramMessage\Elements\Table;
use E4se\TelegramMessage\Elements\TableCaption;
use E4se\TelegramMessage\Elements\TableRow;
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
     * @param string|\Stringable|array<int, string|\Stringable>|null $value
     */
    public function line(string | \Stringable | array | null $value = ""): self
    {
        return $this->text("\n")->text($value);
    }

    /**
     * @param string|\Stringable|array<int, string|\Stringable>|null $value
     */
    public function code(string | \Stringable | array | null $value): self
    {
        return $this->addValueElement(Code::class, $value);
    }

    /**
     * @param string|\Stringable|array<int, string|\Stringable>|null $value
     */
    public function strong(string | \Stringable | array | null $value): self
    {
        return $this->addValueElement(Strong::class, $value);
    }

    /**
     * @param string|\Stringable|array<int, string|\Stringable>|null $value
     */
    public function bold(string | \Stringable | array | null $value): self
    {
        return $this->strong($value);
    }

    /**
     * @param string|\Stringable|array<int, string|\Stringable>|null $value
     */
    public function italic(string | \Stringable | array | null $value): self
    {
        return $this->addValueElement(Italic::class, $value);
    }

    /**
     * @param string|\Stringable|array<int, string|\Stringable>|null $value
     */
    public function strikethrough(string | \Stringable | array | null $value): self
    {
        return $this->addValueElement(Strikethrough::class, $value);
    }

    /**
     * @param string|\Stringable|array<int, string|\Stringable>|null $value
     */
    public function marked(string | \Stringable | array | null $value): self
    {
        return $this->addValueElement(Marked::class, $value);
    }

    /**
     * @param string|\Stringable|array<int, string|\Stringable>|null $value
     */
    public function subscript(string | \Stringable | array | null $value): self
    {
        return $this->addValueElement(Subscript::class, $value);
    }

    /**
     * @param string|\Stringable|array<int, string|\Stringable>|null $value
     */
    public function superscript(string | \Stringable | array | null $value): self
    {
        return $this->addValueElement(Superscript::class, $value);
    }

    /**
     * @param string|\Stringable|array<int, string|\Stringable>|null $value
     */
    public function spoiler(string | \Stringable | array | null $value): self
    {
        return $this->addValueElement(Spoiler::class, $value);
    }

    /**
     * @param string|\Stringable|array<int, string|\Stringable>|null $value
     */
    public function link(string | \Stringable | array | null $value, string $link): self
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
     * @param string|\Stringable|array<int, string|\Stringable>|null $value
     */
    public function strongLink(string | \Stringable | array | null $value, string $link): self
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
     * @param string|\Stringable|array<int, string|\Stringable>|null $value
     */
    public function text(string | \Stringable | array | null $value): self
    {
        return $this->addValueElement(Text::class, $value);
    }

    /**
     * @param string|\Stringable|array<int, string|\Stringable>|null $value
     */
    public function warning(string | \Stringable | array | null $value): self
    {
        return $this->addValueElement(Warning::class, $value);
    }

    /**
     * @param string|\Stringable|array<int, string|\Stringable>|null $value
     */
    public function underline(string | \Stringable | array | null $value): self
    {
        return $this->addValueElement(Underline::class, $value);
    }

    public function anchor(string $name): self
    {
        $this->add(new Anchor($name));
        return $this;
    }

    /**
     * @param string|\Stringable|array<int, string|\Stringable>|null $value
     */
    public function reference(string | \Stringable | array | null $value, string $name): self
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

    public function heading(string | \Stringable | array | null $value, int $level = 1): self
    {
        $this->add(new Heading($value, $level));
        return $this;
    }

    public function h1(string | \Stringable | array | null $value): self
    {
        return $this->heading($value, 1);
    }

    public function h2(string | \Stringable | array | null $value): self
    {
        return $this->heading($value, 2);
    }

    public function h3(string | \Stringable | array | null $value): self
    {
        return $this->heading($value, 3);
    }

    public function h4(string | \Stringable | array | null $value): self
    {
        return $this->heading($value, 4);
    }

    public function h5(string | \Stringable | array | null $value): self
    {
        return $this->heading($value, 5);
    }

    public function h6(string | \Stringable | array | null $value): self
    {
        return $this->heading($value, 6);
    }

    public function paragraph(string | \Stringable | array | null $value): self
    {
        return $this->addValueElement(Paragraph::class, $value);
    }

    public function pre(string | \Stringable | array | null $value): self
    {
        $this->add(new Preformatted($value));
        return $this;
    }

    public function preCode(string | \Stringable | array | null $value, string $language): self
    {
        $this->add(new PreformattedCode($value, $language));
        return $this;
    }

    public function codeBlock(string | \Stringable | array | null $value, string $language): self
    {
        return $this->preCode($value, $language);
    }

    public function footer(string | \Stringable | array | null $value): self
    {
        return $this->addValueElement(Footer::class, $value);
    }

    public function divider(): self
    {
        $this->add(new Divider());
        return $this;
    }

    public function hr(): self
    {
        return $this->divider();
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

    /**
     * @param string|\Stringable|array<int, string|\Stringable>|null $value
     */
    public function checkboxItem(string | \Stringable | array | null $value, bool $checked = false, ?int $valueNumber = null, ?string $type = null): self
    {
        $this->add(
            new ListItem(
                self::create()->checkbox($checked)->text($value),
                $valueNumber,
                $type
            )
        );

        return $this;
    }

    public function caption(string | \Stringable | array | null $value, string | \Stringable | array | null $credit = null): self
    {
        if ($credit === null) {
            $this->add(new Caption($value));
            return $this;
        }

        $caption = self::create();

        if ($value !== null) {
            $caption->text($value);
        }

        $this->add(new Caption($caption->credit($credit)));

        return $this;
    }

    public function credit(string | \Stringable | array | null $value): self
    {
        return $this->addValueElement(Credit::class, $value);
    }

    public function math(string | \Stringable | array | null $value): self
    {
        return $this->addValueElement(MathematicalExpression::class, $value);
    }

    public function mathBlock(string | \Stringable | array | null $value): self
    {
        return $this->addValueElement(MathBlock::class, $value);
    }

    public function blockquote(string | \Stringable | array | null $value, string | \Stringable | array | null $credit = null): self
    {
        if ($credit === null) {
            $this->add(new Blockquote($value));
            return $this;
        }

        $message = self::create();

        if ($value !== null) {
            $message->text($value);
        }

        $this->add(new Blockquote($message->credit($credit)));

        return $this;
    }

    public function pullQuote(string | \Stringable | array | null $value, string | \Stringable | array | null $credit = null): self
    {
        if ($credit === null) {
            $this->add(new PullQuote($value));
            return $this;
        }

        $message = self::create();

        if ($value !== null) {
            $message->text($value);
        }

        $this->add(new PullQuote($message->credit($credit)));

        return $this;
    }

    /**
     * @param string|\Stringable|array<int, \E4se\TelegramMessage\Elements\ListItem|string|\Stringable|array<int, string|\Stringable>>|null $value
     */
    public function richList(string | \Stringable | array | null $value, bool $ordered = false, ?int $start = null, ?string $type = null, bool $reversed = false): self
    {
        $this->add(new ListBlock($value, $ordered, $start, $type, $reversed));
        return $this;
    }

    /**
     * @param string|\Stringable|array<int, \E4se\TelegramMessage\Elements\ListItem|string|\Stringable|array<int, string|\Stringable>>|null $value
     */
    public function unorderedList(string | \Stringable | array | null $value): self
    {
        return $this->richList($value);
    }

    /**
     * @param string|\Stringable|array<int, \E4se\TelegramMessage\Elements\ListItem|string|\Stringable|array<int, string|\Stringable>>|null $value
     */
    public function orderedList(string | \Stringable | array | null $value, ?int $start = null, ?string $type = null, bool $reversed = false): self
    {
        return $this->richList($value, true, $start, $type, $reversed);
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

    public function figure(Element $block, string | \Stringable | array | null $caption = null, string | \Stringable | array | null $credit = null): self
    {
        return $this->addFigure($block, $caption, $credit);
    }

    public function addFigure(Element $block, string | \Stringable | array | null $caption = null, string | \Stringable | array | null $credit = null): self
    {
        $figure = self::create()->add($block);

        if ($caption !== null || $credit !== null) {
            $figure->caption($caption, $credit);
        }

        $this->add(new Figure($figure));

        return $this;
    }

    /**
     * @param string|\Stringable|array<int, Element>|null $value
     */
    public function collage(string | \Stringable | array | null $value, string | \Stringable | array | null $caption = null, string | \Stringable | array | null $credit = null): self
    {
        if ($caption === null && $credit === null) {
            $this->add(new Collage($value));
            return $this;
        }

        $collage = self::create();

        if ($value !== null) {
            $collage->text($value);
        }

        $this->add(new Collage($collage->caption($caption, $credit)));

        return $this;
    }

    /**
     * @param string|\Stringable|array<int, Element>|null $value
     */
    public function slideshow(string | \Stringable | array | null $value, string | \Stringable | array | null $caption = null, string | \Stringable | array | null $credit = null): self
    {
        if ($caption === null && $credit === null) {
            $this->add(new Slideshow($value));
            return $this;
        }

        $slideshow = self::create();

        if ($value !== null) {
            $slideshow->text($value);
        }

        $this->add(new Slideshow($slideshow->caption($caption, $credit)));

        return $this;
    }

    public function details(string | \Stringable | array | null $summary, string | \Stringable | array | null $value, bool $open = false): self
    {
        $this->add(new Details($summary, $value, $open));
        return $this;
    }

    /**
     * @param string|\Stringable|array<int, \E4se\TelegramMessage\Elements\TableRow|array<int, \E4se\TelegramMessage\Elements\TableCell|string|\Stringable|array<int, string|\Stringable>>>|null $value
     */
    public function table(string | \Stringable | array | null $value, bool $bordered = false, bool $striped = false, string | \Stringable | array | null $caption = null): self
    {
        if ($caption === null) {
            $this->add(new Table($value, $bordered, $striped));
            return $this;
        }

        $table = self::create()->add(new TableCaption($caption));

        if (is_array($value)) {
            foreach ($value as $row) {
                $table->add($row instanceof TableRow ? $row : new TableRow($row));
            }
        } elseif ($value !== null) {
            $table->text($value);
        }

        $this->add(new Table($table, $bordered, $striped));

        return $this;
    }

    public function thinking(string | \Stringable | array | null $value): self
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

    public function emoji(string | \Stringable | array | null $value, int | string $emoji_id): self
    {
        $this->add(
            new Emoji(
                value: $value,
                emoji_id: $emoji_id
            )
        );

        return $this;
    }

    public function datetime(string | \Stringable | array | null $value, int $datetime, string $format): self
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
     * @param string|\Stringable|array<int, string|\Stringable>|null $value
     */
    private function addValueElement(string $elementClass, string | \Stringable | array | null $value): self
    {
        $this->add(new $elementClass($value));
        return $this;
    }
}
