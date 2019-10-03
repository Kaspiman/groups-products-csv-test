<?php

class GroupProvider
{
    private $plainGroups;

    private $indexedGroups;

    private $headers;

    public function __construct(array $headers, array $plainGroups)
    {
        $this->plainGroups = $plainGroups;

        $this->headers = $headers;

        $this->compile();
    }

    private function compile()
    {
        $this->indexedGroups = [];

        foreach ($this->plainGroups as $plainGroup) {
            $group = new Group();
            foreach ($this->headers as $index => $header) {
                $group->set($header, $plainGroup[$index]);
            }

            if (empty($group->get('формат описания товаров')) && $group->get('родитель')) {
                if (
                    isset($this->indexedGroups[$group->get('родитель')]) &&
                    ($parent = $this->indexedGroups[$group->get('родитель')]) &&
                    $parent->get('наследовать дочерним')
                ) {
                    $group->set('формат описания товаров', $parent->get('формат описания товаров'));
                }
            }

            $this->indexedGroups[$group->get('id')] = $group;
        }
    }

    public function compileTree(): array
    {
        return $this->buildTree($this->indexedGroups);
    }

    /**
     * @param Group[] $elements
     * @param int $parentId
     * @return array
     */
    private function buildTree(array &$elements, $parentId = 0)
    {
        $result = [];

        foreach ($elements as &$element) {
            if ($element->get('родитель') == $parentId) {
                $children = $this->buildTree($elements, $element->get('id'));

                if ($children) {
                    $element->set('children', $children);
                }

                $result[$element->get('id')] = $element;
                unset($element);
            }
        }

        return $result;
    }
}
