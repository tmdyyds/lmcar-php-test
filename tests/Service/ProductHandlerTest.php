<?php

namespace Test\Service;

use PHPUnit\Framework\TestCase;
use App\Service\ProductHandler;

/**
 * Class ProductHandlerTest
 */
class ProductHandlerTest extends TestCase
{
    private $products = [
        [
            'id' => 1,
            'name' => 'Coca-cola',
            'type' => 'Drinks',
            'price' => 10,
            'create_at' => '2021-04-20 10:00:00',
        ],
        [
            'id' => 2,
            'name' => 'Persi',
            'type' => 'Drinks',
            'price' => 5,
            'create_at' => '2021-04-21 09:00:00',
        ],
        [
            'id' => 3,
            'name' => 'Ham Sandwich',
            'type' => 'Sandwich',
            'price' => 45,
            'create_at' => '2021-04-20 19:00:00',
        ],
        [
            'id' => 4,
            'name' => 'Cup cake',
            'type' => 'Dessert',
            'price' => 35,
            'create_at' => '2021-04-18 08:45:00',
        ],
        [
            'id' => 5,
            'name' => 'New York Cheese Cake',
            'type' => 'Dessert',
            'price' => 40,
            'create_at' => '2021-04-19 14:38:00',
        ],
        [
            'id' => 6,
            'name' => 'Lemon Tea',
            'type' => 'Drinks',
            'price' => 8,
            'create_at' => '2021-04-04 19:23:00',
        ],
    ];

    public function testGetTotalPrice()
    {
        $totalPrice = 0;
        foreach ($this->products as $product) {
            $price = $product['price'] ?? 0;
            $totalPrice += $price;
        }

        $productHandler = new ProductHandler;
        $this->assertEquals($productHandler->getTotalPrice($this->products), $totalPrice);
    }

   public function testGetTypeIsDessert()
    {
        $ret = [];
        $pro = $this->products;

        foreach ($pro as $k => $product) {
           if (strtolower($product['type']) == 'dessert') {
                $ret[] = $product;
           }
        }

        $productHandler = new ProductHandler;
        $dessert        = $productHandler->getTypeIsDessert($pro);

        sort($ret);
        sort($dessert);
        $this->assertJsonStringEqualsJsonString(json_encode($ret), json_encode($dessert));
    }

    public function testConvertDateToUnixTime()
    {
        $time = [];
        $pro  = $this->products;
        foreach ($pro as $k => $product) {
            if (!isset($product['create_at'])
                || strtotime($product['create_at']) == false
            ) {
                continue;
            }

            $pro[$k]['create_at'] = strtotime($product['create_at']);
        }

        $productHandler = new ProductHandler;
        $products       = $productHandler->convertDateToUnixTime($this->products);

        $this->assertJsonStringEqualsJsonString(json_encode($pro), json_encode($products));
    }
}