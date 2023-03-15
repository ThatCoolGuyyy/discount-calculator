<?php

namespace App\Http\Traits;

use App\Models\Customer;
use Illuminate\Support\Str;

trait categoryTrait
{
    /**
     * Get total value of purchase.
     *
     * @param array $items
     * @return array
     */

     public function getDiscountOne(array $order): array
     {
         $reasons = [];
         $discount = 0;
     
         $totalOrderValue = collect($order['total'])->first();
         $customer_id = collect($order['customer-id'])->first();
         $customer=Customer::find($customer_id);
         if ($customer->revenue > 1000.00) {
             $discount = $totalOrderValue * 0.1;
             $reasons[] = "You have a discount of {$discount} because you bought more than €1000.00 worth of products";
         }
         return [
             'discount' => $discount,
             'reasons' => $reasons,
         ];
     }
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
            $discount = $products->sum('unit-price');
            $reasons[] = "You have a discount of {$discount} because you bought more than 5 products from category 2";
        }
            return [
            'discount' => $discount,
            'reasons' => $reasons,
        ];
    }
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
 
         $categoryThreeProducts= collect($order['items'])->filter(function ($item) {
             return Str::startsWith($item['product-id'], 'A1');
         });
         $categoryThreeProductCount = $categoryThreeProducts->sum('quantity');
         if ($categoryThreeProductCount >= 2) {
             $cheapestProduct = $categoryThreeProducts->sortBy('unit-price')->first();
             $discount = $cheapestProduct['unit-price'] * 0.2;
             $reasons[] = "You have a discount of {$discount} because you bought 2 or more products from category 1";
         }
         return [
             'discount' => $discount,
             'reasons' => $reasons,
         ];
     }
}
