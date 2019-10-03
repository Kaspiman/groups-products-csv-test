<?php

require_once 'Entity/Entity.php';
require_once 'Entity/Group.php';
require_once 'Entity/Product.php';

require_once 'Provider/GroupProvider.php';
require_once 'Provider/ProductProvider.php';

require_once 'Renderer/GroupRenderer.php';
require_once 'Renderer/ProductRenderer.php';
require_once 'Renderer/TagRenderer.php';
require_once 'Renderer/CatalogTreeRenderer.php';

require_once 'Reader/CsvFileReader.php';

$groups_file = __DIR__ . '/Resource/groups.csv';
$products_file = __DIR__ . '/Resource/products.csv';

$reader = new CsvFileReader();

list($groupsHeader, $groupsData) = $reader->read($groups_file);
$groupProvider = new GroupProvider($groupsHeader, $groupsData);
$groupsTree = $groupProvider->compileTree();

list($productsHeader, $productsData) = $reader->read($products_file);
$productProvider = new ProductProvider($productsHeader, $productsData);
$productsList = $productProvider->compile();

echo (new CatalogTreeRenderer($groupsTree, $productsList))->render();
