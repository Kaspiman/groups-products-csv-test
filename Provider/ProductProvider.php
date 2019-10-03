<?php

class ProductProvider
{
    private $products;

    private $headers;

    public function __construct(array $headers, array $products)
    {
        $this->headers = $headers;

        $this->products = $products;
    }

    public function compile(): array
    {
        $result = [];

        foreach ($this->products as $plainProduct) {
            $product = new Product();

            foreach ($this->headers as $index => $header) {
                $product->set($header, $plainProduct[$index]);
            }

            if (!isset($result[$product->get('категория')])) {
                $result[$product->get('категория')] = [];
            }

            $result[$product->get('категория')][] = $product;
        }

        return $result;
    }
}
