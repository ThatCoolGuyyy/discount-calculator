<?php

namespace App\Http\Traits;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;

trait discountTrait
{
    /**
     * Get category using id prefix.
     *
     * @param array $items
     * @param string $prefix
     * @return \Illuminate\Support\Collection
     */

    public function getCategory(array $items, string $prefix): Collection
    {
    
         return collect($items)->filter(function ($item) use ($prefix) {
            return Str::startsWith($item['product-id'], $prefix);
        });
    }
}