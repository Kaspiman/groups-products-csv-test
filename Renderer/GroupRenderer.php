<?php

class GroupRenderer
{
    public static function renderPrefix(): string
    {
        return TagRenderer::renderBeginTag('ul') . PHP_EOL;
    }

    public static function renderPostfix(): string
    {
        return
            TagRenderer::renderEndTag('ul') . PHP_EOL;
    }

    public static function renderHeader(Group $group, int $level, int $tabs): string
    {
        return
            TagRenderer::renderTabs($tabs) .
            TagRenderer::renderBeginTag('li') . PHP_EOL .
            TagRenderer::renderTabs($tabs + 1) .
            TagRenderer::renderTag('h' . $level, $group->get('наименование')) . PHP_EOL;
    }

    public static function renderFooter(int $tabs): string
    {
        return TagRenderer::renderTabs($tabs) . TagRenderer::renderEndTag('li') . PHP_EOL;
    }
}
