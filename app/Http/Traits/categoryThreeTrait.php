<?php

namespace App\Http\Traits;

use Illuminate\Support\Str;

trait categoryThreeTrait
{
    /**
     * Get items in category 1 using id prefix.
     *
     * @param array $items
     * @return array
     */

    public function getDiscountThree(array $order): array
    {
        $reasons = [];
        $discount = 0;

        $categoryOneProducts =  $categoryOneProducts = collect($order['items'])->filter(function ($item) {
            return Str::startsWith($item['product-id'], 'A1');
        });
        $categoryOneProductCount = $categoryOneProducts->sum('quantity');
        if ($categoryOneProductCount >= 2) {
            $cheapestProduct = $categoryOneProducts->sortBy('unit-price')->first();
            $discount = $cheapestProduct['unit-price'] * 0.2;
            $reasons[] = "You have a discount of {$discount} you bought 2 or more products from category 1";
        }
        return [
            'discount' => $discount,
            'reasons' => $reasons,
        ];
    }
}
