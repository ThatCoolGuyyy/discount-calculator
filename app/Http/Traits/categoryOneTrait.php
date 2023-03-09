<?php

namespace App\Http\Traits;

use App\Models\Customer;

trait categoryOneTrait
{
    

    public function getDiscountOne(array $order)
    {
        $reasons = [];
        $discount = 0;
    
        $totalOrderValue = collect($order['total'])->first();
        $customer_id = collect($order['customer-id'])->first();
        $customer=Customer::find($customer_id);
        if ($customer->revenue > 100.00) {
            $discount += $totalOrderValue * 0.1;
            $category_discount = $totalOrderValue * 0.1;
            $reasons[] = "You have a discount of {$category_discount} because you bought more than €1000.00 worth of products";
        }
        // dd($reasons);
        return [
            'discount' => $discount,
            'reasons' => $reasons,
        ];
    }
}