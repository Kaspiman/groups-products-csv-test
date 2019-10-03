<?php

class ProductRenderer
{
    public static function renderProductsPrefix(int $level): string
    {
        return TagRenderer::renderTabs($level) . TagRenderer::renderBeginTag('ul') . PHP_EOL;
    }

    public static function renderProductsPostfix(int $level): string
    {
        return TagRenderer::renderTabs($level) . TagRenderer::renderEndTag('ul') . PHP_EOL;
    }

    public static function render(Product $product, Group $group, $tabs): string
    {
        return TagRenderer::renderTabs($tabs) . TagRenderer::renderTag(
                'li',
                TagRenderer::renderTag(
                    'b',
                    self::renderProductTitle($product, $group)
                )
            ) . PHP_EOL;
    }

    public static function renderProductTitle(Product $product, Group $group): string
    {
        $content = $group->get('формат описания товаров');

        $fields = [];

        preg_match_all("/[%]+(?<attributes>[^%]+)+[%]/", $content, $fields);

        if (isset($fields['attributes'])) {
            foreach ($fields['attributes'] as $field) {
                if ($product->exists($field)) {
                    $attribute = $product->get($field);
                } else {
                    $attribute = 'UNDEFINED';
                }
                $content = str_replace('%' . $field . '%', $attribute, $content);
            }
        }

        return $content;
    }
}
