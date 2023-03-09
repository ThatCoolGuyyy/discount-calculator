<?php

namespace App\Http\Traits;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use App\Http\Requests\discountRequest;
use App\Http\Controllers\discountController;

trait categoryThreeTrait
{
    /**
     * Get category using id prefix.
     *
     * @param array $items
     * @param string $prefix
     * @return 
     */

    public function getDiscountThree(array $order)
    {
        // $order = json_decode(json_encode($request->input(), true), true); //converting to associative array
        $reasons = [];
        $discount = 0;

        $categoryOneProducts =  $categoryOneProducts = collect($order['items'])->filter(function ($item) {
            return Str::startsWith($item['product-id'], 'A1');
        });
        $categoryOneProductCount = $categoryOneProducts->sum('quantity');
        if ($categoryOneProductCount >= 2) {
            $cheapestProduct = $categoryOneProducts->sortBy('unit-price')->first();
            $discount += $cheapestProduct['unit-price'] * 0.2;
            $category_discount = $cheapestProduct['unit-price'] * 0.2;
            $reasons[] = "You have a discount of {$category_discount} you bought 2 or more products from category 1";
        }
        return [
            'discount' => $discount,
            'reasons' => $reasons,
        ];
    }
}
