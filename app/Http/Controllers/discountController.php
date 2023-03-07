<?php

namespace App\Http\Controllers;

use Exception;
use App\Http\Requests\discountRequest;
use App\Http\Traits\discountTrait;


class discountController extends Controller
{
    use discountTrait;

     public function calculate(discountRequest $request)
    {
        $input = json_encode($request->input(), true); //converting to string
        print_r($input);
        $order = json_decode($input, true); //converting to associative array
        $reasons = [];
        $discount = 0;

        // Get total order value
        try{
            $totalOrderValue = collect($order['total'])->first();
        }
        catch(Exception $e){
            return response()->json(['error' => 'Invalid order data'], 400);
        }

        // Check for discount 1
        if ($totalOrderValue > 100.00) {
            $discount += $totalOrderValue * 0.1;
            $category_discount = $totalOrderValue * 0.1;
            $reasons[] = "You have a discount of {$discount} because you bought more than 1000.00 worth of products";

        }

         // Check for discount 2
        try{
            $categoryTwoProducts = $this->getCategory($order['items'], 'B1');
        }
        catch(Exception $e){
            return response()->json(['error' => 'Invalid order data'], 400);
        }
        $discountedProducts = $categoryTwoProducts->filter(function ($product) {
            return $product['quantity'] > 5;
        });
        $discountedProductCount = $discountedProducts->count();
        if ($discountedProductCount > 0) {
            $discount += $discountedProducts->sum('unit-price');
            $category_discount = $discountedProducts->sum('unit-price');
            $reasons[] = "You have a discount of {$category_discount} because you bought more than 5 products from category 2";
        }

        // Check for discount 3
        $categoryOneProductCount = 0;
        try{
            $categoryOneProducts = $this->getCategory($order['items'], 'A1');
        }
        catch(Exception $e){
            return response()->json(['error' => 'Invalid order data'], 400);
        }        
        $categoryOneProductCount = $categoryOneProducts->sum('quantity');
        if ($categoryOneProductCount >= 2) {
            $cheapestCategoryOneProduct = $categoryOneProducts->sortBy('unit-price')->first();
            $discount += $cheapestCategoryOneProduct['unit-price'] * 0.2;
            $category_discount = $cheapestCategoryOneProduct['unit-price'] * 0.2;
            $reasons[] = "You have a discount of {$category_discount} you bought 2 or more products from category 1";

        }

        return response()->json(
            [
                'discount' => $discount,
                'reasons' => $reasons
            ]);
    }
}


