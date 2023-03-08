<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Support\Str;
use App\Http\Traits\discountTrait;
use App\Http\Requests\discountRequest;


class discountController extends Controller
{
    use discountTrait;

     public function calculate(discountRequest $request)
    {
        $input = json_encode($request->input(), true); //converting to string
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
        Customer::
        if ($totalOrderValue > 1000.00) {
            $discount += $totalOrderValue * 0.1;
            $category_discount = $totalOrderValue * 0.1;
            $reasons[] = "You have a discount of {$discount} because you bought more than 1000.00 worth of products";

        }

         // Check for discount 2
         if (in_array(true, array_map(function ($item) {
            return Str::startsWith($item['product-id'], 'B1');
        }, $order['items']))) {
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
        }

        // Check for discount 3
        $categoryOneProductCount = 0;
        if (in_array(true, $goat = array_map(function ($item) {
            return Str::startsWith($item['product-id'], 'A1');
        }, $order['items']))) {
            print_r($goat);

            $categoryOneProducts = $this->getCategory($order['items'], 'A1');
            $categoryOneProductCount = $categoryOneProducts->sum('quantity');
            if ($categoryOneProductCount >= 2) {
                $cheapestProduct = $categoryOneProducts->sortBy('unit-price')->first();
                $discount += $cheapestProduct['unit-price'] * 0.2;
                $category_discount = $cheapestProduct['unit-price'] * 0.2;
                $reasons[] = "You have a discount of {$category_discount} you bought 2 or more products from category 1";

            }
    }

        return response()->json(
            [
                'discount' => $discount,
                'reasons' => $reasons
            ]);
    }
}


