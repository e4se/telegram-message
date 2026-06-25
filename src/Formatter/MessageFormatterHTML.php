<?php

namespace E4se\TelegramMessage\Formatter;

use E4se\TelegramMessage\Elements\Anchor;
use E4se\TelegramMessage\Elements\Animation;
use E4se\TelegramMessage\Elements\Audio;
use E4se\TelegramMessage\Elements\Blockquote;
use E4se\TelegramMessage\Elements\Checkbox;
use E4se\TelegramMessage\Elements\Cite;
use E4se\TelegramMessage\Elements\Code;
use E4se\TelegramMessage\Elements\Collage;
use E4se\TelegramMessage\Elements\Datetime;
use E4se\TelegramMessage\Elements\Details;
use E4se\TelegramMessage\Elements\Divider;
use E4se\TelegramMessage\Elements\Element;
use E4se\TelegramMessage\Elements\Emoji;
use E4se\TelegramMessage\Elements\EmojiImage;
use E4se\TelegramMessage\Elements\Figcaption;
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
use E4se\TelegramMessage\Elements\PullQuote;
use E4se\TelegramMessage\Elements\Reference;
use E4se\TelegramMessage\Elements\Slideshow;
use E4se\TelegramMessage\Elements\Spoiler;
use E4se\TelegramMessage\Elements\Strikethrough;
use E4se\TelegramMessage\Elements\Strong;
use E4se\TelegramMessage\Elements\Subscript;
use E4se\TelegramMessage\Elements\Superscript;
use E4se\TelegramMessage\Elements\Table;
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
            Link::class => $this->tag('a', "{$element}", ['href' => $element->link]) . ' ',
            Strong::class => $this->tag('b', "{$element}"),
            Italic::class => $this->tag('i', "{$element}"),
            Underline::class => $this->tag('u', "{$element}"),
            Strikethrough::class => $this->tag('s', "{$element}"),
            Code::class => $this->tag('code', "{$element}"),
            Marked::class => $this->tag('mark', "{$element}"),
            Subscript::class => $this->tag('sub', "{$element}"),
            Superscript::class => $this->tag('sup', "{$element}"),
            Spoiler::class => $this->tag('tg-spoiler', "{$element}"),
            Emoji::class => $this->tag('tg-emoji', "{$element}", ['emoji-id' => $element->emoji_id]),
            Datetime::class => $this->tag('tg-time', "{$element}", ['unix' => $element->datetime, 'format' => $element->format]),
            EmojiImage::class => $this->singleTag('img', ['src' => $element->src, 'alt' => $element->alt]),
            MathematicalExpression::class => $this->tag('tg-math', "{$element}"),
            Reference::class => $this->tag('tg-reference', "{$element}", ['name' => $element->name]),
            Anchor::class => $this->tag('a', '', ['name' => $element->name]),
            Heading::class => $this->tag('h' . $element->level, "{$element}"),
            Paragraph::class => $this->tag('p', "{$element}"),
            Preformatted::class => $this->renderPreformatted($element),
            Footer::class => $this->tag('footer', "{$element}"),
            Divider::class => $this->singleTag('hr'),
            LineBreak::class => $this->singleTag('br', [], false),
            MathBlock::class => $this->tag('tg-math-block', "{$element}"),
            Cite::class => $this->tag('cite', "{$element}"),
            Blockquote::class => $this->tag('blockquote', "{$element}" . $this->renderCredit($element->credit)),
            PullQuote::class => $this->tag('aside', "{$element}" . $this->renderCredit($element->credit)),
            ListBlock::class => $this->renderList($element),
            ListItem::class => $this->renderListItem($element),
            Checkbox::class => $this->singleTag('input', ['type' => 'checkbox', 'checked' => $element->checked], false),
            Figcaption::class => $this->renderFigcaption($element->value, $element->credit),
            Figure::class => $this->tag('figure', $this->render($element->block) . $this->renderFigcaption($element->caption, $element->credit)),
            Photo::class => $this->singleTag('img', ['src' => $element->src, 'alt' => $element->alt, 'tg-spoiler' => $element->hasSpoiler]),
            Animation::class => $this->tag('video', '', ['src' => $element->src, 'tg-spoiler' => $element->hasSpoiler]),
            Video::class => $this->tag('video', '', ['src' => $element->src, 'tg-spoiler' => $element->hasSpoiler]),
            VoiceNote::class => $this->tag('audio', '', ['src' => $element->src]),
            Audio::class => $this->tag('audio', '', ['src' => $element->src]),
            MapElement::class => $this->singleTag('tg-map', [
                'lat' => $element->lat,
                'long' => $element->long,
                'zoom' => $element->zoom,
                'width' => $element->width,
                'height' => $element->height,
            ]),
            Collage::class => $this->renderBlockCollection('tg-collage', $element->blocks, $element->caption, $element->credit),
            Slideshow::class => $this->renderBlockCollection('tg-slideshow', $element->blocks, $element->caption, $element->credit),
            Table::class => $this->renderTable($element),
            Details::class => $this->tag('details',
                $this->tag('summary', Element::renderValue($element->summary)) . "{$element}",
                ['open' => $element->open]
            ),
            Thinking::class => $this->tag('tg-thinking', "{$element}"),
            default => "{$element}",
        };
    }

    private function renderPreformatted(Preformatted $element): string
    {
        $content = "{$element}";

        if ($element->language === null) {
            return $this->tag('pre', $content);
        }

        return $this->tag('pre', $this->tag('code', $content, ['class' => 'language-' . $element->language]));
    }

    private function renderList(ListBlock $element): string
    {
        $tag = $element->ordered ? 'ol' : 'ul';
        $attributes = [];

        if ($element->ordered) {
            $attributes = [
                'start' => $element->start,
                'type' => $element->type,
                'reversed' => $element->reversed,
            ];
        }

        $content = '';
        foreach ($element->items as $item) {
            $content .= $item instanceof ListItem
                ? $this->renderListItem($item)
                : $this->tag('li', Element::renderValue($item));
        }

        return $this->tag($tag, $content, $attributes);
    }

    private function renderListItem(ListItem $element): string
    {
        $content = '';

        if ($element->hasCheckbox) {
            $content .= $this->singleTag('input', ['type' => 'checkbox', 'checked' => $element->isChecked], false);
        }

        $content .= "{$element}";

        return $this->tag('li', $content, [
            'value' => $element->valueNumber,
            'type' => $element->type,
        ]);
    }

    /**
     * @param string|Element|array<int, string|Element>|null $caption
     * @param string|Element|array<int, string|Element>|null $credit
     */
    private function renderFigcaption(string | Element | array | null $caption, string | Element | array | null $credit = null): string
    {
        if ($caption === null && $credit === null) {
            return '';
        }

        if ($caption instanceof Figcaption) {
            return $this->tag('figcaption', Element::renderValue($caption->value) . $this->renderCredit($credit ?? $caption->credit));
        }

        return $this->tag('figcaption', Element::renderValue($caption) . $this->renderCredit($credit));
    }

    /**
     * @param array<int, Element> $blocks
     * @param string|Element|array<int, string|Element>|null $caption
     * @param string|Element|array<int, string|Element>|null $credit
     */
    private function renderBlockCollection(string $tag, array $blocks, string | Element | array | null $caption = null, string | Element | array | null $credit = null): string
    {
        $content = '';
        foreach ($blocks as $block) {
            $content .= Element::renderValue($block);
        }

        return $this->tag($tag, $content . $this->renderFigcaption($caption, $credit));
    }

    private function renderTable(Table $table): string
    {
        $content = $table->caption === null
            ? ''
            : $this->tag('caption', Element::renderValue($table->caption));

        foreach ($table->rows as $row) {
            $content .= $this->renderTableRow($row);
        }

        return $this->tag('table', $content, [
            'bordered' => $table->bordered,
            'striped' => $table->striped,
        ]);
    }

    /**
     * @param TableRow|array<int, TableCell|string|Element|array<int, string|Element>> $row
     */
    private function renderTableRow(TableRow | array $row): string
    {
        $cells = $row instanceof TableRow ? $row->cells : $row;
        $content = '';

        foreach ($cells as $cell) {
            $content .= $this->renderTableCell($cell);
        }

        return $this->tag('tr', $content);
    }

    /**
     * @param TableCell|string|Element|array<int, string|Element>|null $cell
     */
    private function renderTableCell(TableCell | string | Element | array | null $cell): string
    {
        if (!$cell instanceof TableCell) {
            return $this->tag('td', Element::renderValue($cell));
        }

        return $this->tag($cell->isHeader ? 'th' : 'td', Element::renderValue($cell->value), [
            'colspan' => $cell->colspan,
            'rowspan' => $cell->rowspan,
            'align' => $cell->align,
            'valign' => $cell->valign,
        ]);
    }

    /**
     * @param string|Element|array<int, string|Element>|null $credit
     */
    private function renderCredit(string | Element | array | null $credit): string
    {
        return $credit === null ? '' : $this->tag('cite', Element::renderValue($credit));
    }

    /**
     * @param array<string, string|int|float|bool|null> $attributes
     */
    private function tag(string $tag, string $content, array $attributes = []): string
    {
        return "<{$tag}{$this->attributes($attributes)}>{$content}</{$tag}>";
    }

    /**
     * @param array<string, string|int|float|bool|null> $attributes
     */
    private function singleTag(string $tag, array $attributes = [], bool $closed = true): string
    {
        return "<{$tag}{$this->attributes($attributes)}" . ($closed ? '/>' : '>');
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
