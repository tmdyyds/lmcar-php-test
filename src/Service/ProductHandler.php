<?php

namespace App\Service;

class ProductHandler
{
    const PRICE_DEFAULT_ZERO = 0;
    const PRICE_SORT_ROW     = 'price';

    public function getTotalPrice(array $products)
    {
        if (empty($products)) {
            return self::PRICE_DEFAULT_ZERO;
        }

        $totalPrice = self::PRICE_DEFAULT_ZERO;
        foreach ($products as $product) {
            isset($product['price']) ? $totalPrice += intval($product['price']) : self::PRICE_DEFAULT_ZERO;
        }

        return $totalPrice;
    }

    public function getTypeIsDessert(array $products)
    {
        //默认空商品
        if (empty($products)) {
            return [];
        }

        $sortRow = array_column($products, self::PRICE_SORT_ROW);
        if (array_multisort($sortRow, SORT_DESC, SORT_NUMERIC, $products)) {
            return array_filter($products, function($product) {
                return isset($product['type']) ? strtolower($product['type']) == 'dessert' : false;
            });
        }

        return [];
    }

    public function convertDateToUnixTime(array $products)
    {
        if (empty($products)) {
            return false;
        }

        return array_map(function ($product) {
            if (!isset($product['create_at'])
                || strtotime($product['create_at']) == false
            ) {
                return $product;
            }

            $product['create_at'] = strtotime($product['create_at']);
            return $product;
        }, $products);
    }
}