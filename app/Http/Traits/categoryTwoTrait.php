<?php

namespace App\Http\Traits;
use Illuminate\Support\Collection;


trait categoryTwoTrait
{
    public function getDiscountTwo(array $order)
    {

            $reasons = [];
            $discount = 0;

            $categoryTwoProducts = $this->getCategory($order['items'], 'B1'); //change to in_array
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
