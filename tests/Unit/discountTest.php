<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Http\Requests\discountRequest;
use App\Http\Controllers\discountController;

class discountTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_toCalculateDiscount()
    {
        $discountController = new discountController();
        $request = new discountRequest([
            'id' => '3',
            'customer-id' => '3',
            'items' => [
                [
                    'product-id' => 'A101',
                    'quantity' => '2',
                    'unit-price' => '9.75',
                    'total' => '19.50'
                ],
                [
                    'product-id' => 'A102',
                    'quantity' => '1',
                    'unit-price' => '49.50',
                    'total' => '49.50'
                ]
            ],
            'total' => '69.00'
        ]);
        $response = $discountController->calculate($request);
        $this->assertsame(1.9500000000000002, json_decode($response->getContent())->discount);
        $this->assertSame(
            [
                "You have a discount of 1.95 you bought 2 or more products from category 1"
            ],json_decode($response->getContent())->reasons);

    }
}
