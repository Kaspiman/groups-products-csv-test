<?php

class CatalogTreeRenderer
{
    private $groups;

    private $products;

    public function __construct(array $groups, array $products)
    {
        $this->products = $products;
        $this->groups = $groups;
    }

    public function render()
    {
        if (empty($this->groups)) {
            return '';
        }

        $level = 1;
        $tree = '';

        foreach ($this->groups as $group) {
            $tree .= GroupRenderer::renderPrefix() .
                $this->renderGroup($group, $level, 1) .
                GroupRenderer::renderPostfix();
        }

        return $tree;
    }

    private function renderGroup(Group $group, int $level, int $tabs): string
    {
        $content = GroupRenderer::renderHeader($group, $level, $tabs);

        $renderHeaders = isset($this->products[$group->get('id')]) || !empty($group->get('children'));

        if ($renderHeaders) {
            $content .= ProductRenderer::renderProductsPrefix($tabs + 1);
        }

        if (isset($this->products[$group->get('id')]) && ($products = $this->products[$group->get('id')])) {
            foreach ($products as $product) {
                $content .= ProductRenderer::render($product, $group, $tabs + 2);
            }
        }

        if (($children = $group->get('children'))) {
            foreach ($children as $child) {
                $content .= $this->renderGroup($child, $level + 1, $tabs + 2);
            }
        }

        if ($renderHeaders) {
            $content .= ProductRenderer::renderProductsPostfix($tabs + 1);
        }

        $content .= GroupRenderer::renderFooter($tabs);

        return $content;
    }
}
