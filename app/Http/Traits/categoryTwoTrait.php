<?php

namespace App\Http\Traits;

use Illuminate\Support\Str;

trait categoryTwoTrait
{
    /**
     * Get items in category 2 using id prefix.
     *
     * @param array $items
     * @return array
     */
    public function getDiscountTwo(array $order): array
    {

        $reasons = [];
        $discount = 0;

        $categoryTwoProducts = collect($order['items'])->filter(function ($item) {
            return Str::startsWith($item['product-id'], 'B1');
        });
        $products = $categoryTwoProducts->filter(function ($product) {
            return $product['quantity'] > 5;
        });
        $ProductsCount = $products->count();

        if ($ProductsCount > 0) {
            $discount += $products->sum('unit-price');
            $category_discount = $products->sum('unit-price');
            $reasons[] = "You have a discount of {$category_discount} because you bought more than 5 products from category 2";
        }
            return [
            'discount' => $discount,
            'reasons' => $reasons,
        ];
    }
}
