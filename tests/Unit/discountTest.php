<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Http\Traits\categoryTrait;


class discountTest extends TestCase
{
    
    use categoryTrait;

    public function test_discountOneFails(){

        $order = [ // failing because customer of id 4 has not purchased more than €1000.00 worth of products
            "id" => "4",
            "customer-id" => "4",
            "items" => [
                [
                    "product-id" => "A202",
                    "quantity" => "10",
                    "unit-price" => "75.00",
                    "total" => "750.00",
                ],
                [
                    "product-id" => "B201",
                    "quantity" => "5",
                    "unit-price" => "150.00",
                    "total" => "750.00",
                ],
            ],
            "total" => "1500.00",
        ];
        $discountOneReult = $this->getDiscountOne($order);
        $expected_discount = 0;
        $this->assertEquals($expected_discount, $discountOneReult['discount']);


    }
    public function test_discountOnePasses(){

        $order = [
            "id" => "4",
            "customer-id" => "1",
            "items" => [
                [
                    "product-id" => "A202",
                    "quantity" => "10",
                    "unit-price" => "75.00",
                    "total" => "750.00",
                ],
                [
                    "product-id" => "B201",
                    "quantity" => "5",
                    "unit-price" => "150.00",
                    "total" => "750.00",
                ],
            ],
            "total" => "1500.00",
        ];
        $discountOneReult = $this->getDiscountOne($order);
        $expected_discount = 150;
        $expected_reason = "You have a discount of 150 because you bought more than €1000.00 worth of products";
        $this->assertEquals($expected_discount, $discountOneReult['discount']);
        $this->assertEquals($expected_reason, $discountOneReult['reasons'][0]);


    }
    public function test_discountTwo(){

        $order = [
            "id" => "3",
            "customer-id" => "3",
            "items" => [
                [
                    "product-id" => "B101",
                    "quantity" => "6",
                    "unit-price" => "9.75",
                    "total" => "19.50",
                ],
                [
                    "product-id" => "B102",
                    "quantity" => "6",
                    "unit-price" => "49.50",
                    "total" => "49.50",
                ],
            ],
            "total" => "69.00",
        ];

        $discountTwoResult = $this->getDiscountTwo($order);
        $expected_discount = 59.25;
        $expected_reason = "You have a discount of 59.25 because you bought more than 5 products from category 2";
        $this->assertEquals($expected_discount, $discountTwoResult['discount']);
        $this->assertEquals($expected_reason, $discountTwoResult['reasons'][0]);
    }
    public function test_discountThree(){

        $order = [
            "id" => "3",
            "customer-id" => "3",
            "items" => [
                [
                    "product-id" => "A101",
                    "quantity" => "3",
                    "unit-price" => "11.75",
                    "total" => "35.25",
                ],
                [
                    "product-id" => "A102",
                    "quantity" => "6",
                    "unit-price" => "16.50",
                    "total" => "99.00",
                ],
            ],
            "total" => "199.50",
        ];
        $expected_discount = 2.35;
        $expected_reason = "You have a discount of 2.35 because you bought 2 or more products from category 1";
        $discountThreeResult = $this->getDiscountThree($order);
        $this->assertEquals($expected_discount, $discountThreeResult['discount']);
        $this->assertEquals($expected_reason, $discountThreeResult['reasons'][0]);
    }
}
