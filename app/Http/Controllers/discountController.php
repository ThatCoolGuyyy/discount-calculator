<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Customer;
use Illuminate\Support\Str;
use App\Http\Traits\categoryTwoTrait;
use App\Http\Requests\discountRequest;
use App\Http\Traits\categoryOneTrait;
use App\Http\Traits\categoryThreeTrait;


class discountController extends Controller
{
    use categoryThreeTrait, categoryTwoTrait, categoryOneTrait;

     public function calculate(discountRequest $request)
    {
        $input = json_encode($request->input(), true); //converting to string
        // $order = json_decode(json_encode($request->input(), true), true); //converting to associative array
        $order = json_decode($input, true); //converting to associative array
        $reasons = [];
        $discount = 0;

        // Check for discount 1
        $discountOneResult = ['discount' => 0, 'reasons' => []];
        $discountOneResult = $this->getDiscountOne($order);

         // Check for discount 2
         $discountTwoResult = ['discount' => 0, 'reasons' => []];
         if (in_array(true, array_map(function ($item) {
            return Str::startsWith($item['product-id'], 'B1');
            }, $order['items']))) 
        {
            $discountTwoResult = $this->getDiscountTwo($order);
        }

        // Check for discount 3
        $discountThreeResult = ['discount' => 0, 'reasons' => []];
        if (in_array(true, array_map(function ($item) {
            return Str::startsWith($item['product-id'], 'A1');
            }, $order['items']))) 
        {
            $discountThreeResult = $this->getDiscountThree($order);
        }

        $discount += $discountOneResult['discount'];
        $discount += $discountTwoResult['discount'];
        $discount += $discountThreeResult['discount'];

        $reasons = array_merge($reasons, $discountOneResult['reasons']);
        $reasons = array_merge($reasons, $discountTwoResult['reasons']);
        $reasons = array_merge($reasons, $discountThreeResult['reasons']);


        // $discounts = [$discountOneResult, $discountTwoResult, $discountThreeResult];
        // $reasons = [];

        // foreach ($discounts as $discountResult) {
        //     $discount += $discountResult['discount'];
        //     $reasons = array_merge($reasons, $discountResult['reasons']);
        // }


        return response()->json([
            'discount' => round($discount, 2),
            'reasons' => $reasons,
        ]);
    }
}


