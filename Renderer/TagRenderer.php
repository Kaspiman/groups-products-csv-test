<?php

class TagRenderer
{
    public static function renderTabs(int $count): string
    {
        return str_repeat("\t", $count);
    }

    public static function renderTag(string $tag, string $content): string
    {
        return self::renderBeginTag($tag) . $content . self::renderEndTag($tag);
    }

    public static function renderBeginTag(string $tag): string
    {
        return '<' . $tag . '>';
    }

    public static function renderEndTag(string $tag): string
    {
        return '</' . $tag . '>';
    }
}
