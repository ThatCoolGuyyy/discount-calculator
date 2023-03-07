<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Support\Str;
use App\Http\Requests\discountRequest;


class discountController extends Controller
{
     public function calculate(discountRequest $request)
    {
        $input = json_encode($request->input(), true); //converting to string
        $order = json_decode($input, true); //converting to associative array
        $reasons = [];
        $discount = 0;

        $totalOrderValue = collect($order['total'])->first();

        // Check for discount 1
        if ($totalOrderValue > 1000.00) {
            $discount += $totalOrderValue * 0.1;
            $category_discount = $totalOrderValue * 0.1;
            array_push($reasons, "You have a discount of " . $category_discount .
             " because you bought more than 1000.00 worth of products");
        }

        // Check for discount 2
        
        $categoryTwoProducts = collect($order['items'])->filter(function ($item) {
            return Str::startsWith($item['product-id'], 'B1');
          
        });
    
        foreach($categoryTwoProducts as $product) {
            if($product['quantity'] > 5) {
                $discount += $product['unit-price'];
                $category_discount = $discount;
                array_push($reasons, "You have a discount of " . $category_discount . 
                " You bought 5 or more products from category 2");
                break;
            }  
        }     
    
        // Check for discount 3

        $categoryOneProducts = collect($order['items'])->filter(function ($item) {
            return Str::startsWith($item['product-id'], 'A1');
        });
        $categoryOneProductCount = $categoryOneProducts->sum('quantity');
        if ($categoryOneProductCount >= 2) {
            $cheapestCategoryOneProduct = $categoryOneProducts->sortBy('unit-price')->first();
            $discount += $cheapestCategoryOneProduct['unit-price'] * 0.2;
            $category_discount = $cheapestCategoryOneProduct['unit-price'] * 0.2;
            array_push($reasons, "You have a discount of " . $category_discount . 
            " you bought 2 or more products from category 1");
        }

        return response()->json(
            [
                'discount' => $discount,
                'reasons' => $reasons
            ]);
    }
}


