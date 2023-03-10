<?php

namespace App\Http\Traits;
use App\Models\Customer;

trait categoryOneTrait
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
}