<?php

namespace E4se\TelegramMessage\Formatter;

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
use E4se\TelegramMessage\Elements\TableCell;
use E4se\TelegramMessage\Elements\TableRow;
use E4se\TelegramMessage\Elements\Thinking;
use E4se\TelegramMessage\Elements\Underline;
use E4se\TelegramMessage\Elements\Video;
use E4se\TelegramMessage\Elements\VoiceNote;
use E4se\TelegramMessage\Elements\Warning;

class MessageFormatterHTML implements MessageFormatterInterface
{
    public function getFormat(): string
    {
        return "HTML";
    }

    public function render(Element $element): string
    {
        return match ($element::class) {
            Warning::class => "<b>❗️❗️❗️{$element}❗️❗️❗️ </b>",
            Link::class => "<a href=\"{$this->escape($element->link)}\">{$element}</a> ",
            Strong::class => "<b>{$element}</b>",
            Italic::class => "<i>{$element}</i>",
            Underline::class => "<u>{$element}</u>",
            Strikethrough::class => "<s>{$element}</s>",
            Code::class => "<code>{$element}</code>",
            Marked::class => "<mark>{$element}</mark>",
            Subscript::class => "<sub>{$element}</sub>",
            Superscript::class => "<sup>{$element}</sup>",
            Spoiler::class => "<tg-spoiler>{$element}</tg-spoiler>",
            Emoji::class => "<tg-emoji emoji-id=\"{$this->escape((string) $element->emoji_id)}\">{$element}</tg-emoji>",
            Datetime::class => "<tg-time unix=\"{$element->datetime}\" format=\"{$this->escape($element->format)}\">{$element}</tg-time>",
            MathematicalExpression::class => "<tg-math>{$element}</tg-math>",
            Reference::class => "<tg-reference name=\"{$this->escape($element->name)}\">{$element}</tg-reference>",
            Anchor::class => "<a name=\"{$this->escape($element->name)}\"></a>",
            Heading::class => "<h{$element->level}>{$element}</h{$element->level}>",
            Paragraph::class => "<p>{$element}</p>",
            Preformatted::class => "<pre>{$element}</pre>",
            PreformattedCode::class => "<pre><code class=\"language-{$this->escape($element->language)}\">{$element}</code></pre>",
            Footer::class => "<footer>{$element}</footer>",
            Divider::class => "<hr/>",
            LineBreak::class => "<br>",
            MathBlock::class => "<tg-math-block>{$element}</tg-math-block>",
            Caption::class => "<figcaption>{$element}</figcaption>",
            Credit::class => "<cite>{$element}</cite>",
            Blockquote::class => "<blockquote>{$element}</blockquote>",
            PullQuote::class => "<aside>{$element}</aside>",
            ListBlock::class => "<" . ($element->ordered ? 'ol' : 'ul') . "{$this->attributes([
                'start' => $element->ordered ? $element->start : null,
                'type' => $element->ordered ? $element->type : null,
                'reversed' => $element->ordered && $element->reversed,
            ])}>{$element}</" . ($element->ordered ? 'ol' : 'ul') . ">",
            ListItem::class => "<li{$this->attributes(['value' => $element->valueNumber, 'type' => $element->type])}>{$element}</li>",
            Checkbox::class => "<input type=\"checkbox\"{$this->attributes(['checked' => $element->checked])}>",
            Figure::class => "<figure>{$element}</figure>",
            Photo::class => "<img{$this->attributes(['src' => $element->src, 'alt' => $element->alt, 'tg-spoiler' => $element->hasSpoiler])}/>",
            Animation::class => "<video{$this->attributes(['src' => $element->src, 'tg-spoiler' => $element->hasSpoiler])}></video>",
            Video::class => "<video{$this->attributes(['src' => $element->src, 'tg-spoiler' => $element->hasSpoiler])}></video>",
            VoiceNote::class => "<audio{$this->attributes(['src' => $element->src])}></audio>",
            Audio::class => "<audio{$this->attributes(['src' => $element->src])}></audio>",
            MapElement::class => "<tg-map{$this->attributes([
                'lat' => $element->lat,
                'long' => $element->long,
                'zoom' => $element->zoom,
                'width' => $element->width,
                'height' => $element->height,
            ])}/>",
            Collage::class => "<tg-collage>{$element}</tg-collage>",
            Slideshow::class => "<tg-slideshow>{$element}</tg-slideshow>",
            Table::class => "<table{$this->attributes(['bordered' => $element->bordered, 'striped' => $element->striped])}>{$element}</table>",
            TableCaption::class => "<caption>{$element}</caption>",
            TableRow::class => "<tr>{$element}</tr>",
            TableCell::class => "<" . ($element->isHeader ? 'th' : 'td') . "{$this->attributes([
                'colspan' => $element->colspan,
                'rowspan' => $element->rowspan,
                'align' => $element->align,
                'valign' => $element->valign,
            ])}>{$element}</" . ($element->isHeader ? 'th' : 'td') . ">",
            Details::class => "<details{$this->attributes(['open' => $element->open])}><summary>" . Element::renderValue($element->summary) . "</summary>{$element}</details>",
            Thinking::class => "<tg-thinking>{$element}</tg-thinking>",
            default => "{$element}",
        };
    }

    /**
     * @param array<string, string|int|float|bool|null> $attributes
     */
    private function attributes(array $attributes): string
    {
        $html = [];

        foreach ($attributes as $name => $value) {
            if ($value === null || $value === false) {
                continue;
            }

            if ($value === true) {
                $html[] = $name;
                continue;
            }

            $html[] = $name . '="' . $this->escape((string) $value) . '"';
        }

        return $html === [] ? '' : ' ' . implode(' ', $html);
    }

    private function escape(string $value): string
    {
        return htmlspecialchars($value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
    }
}
