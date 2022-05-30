<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;


class CartItem
{
    use HasFactory;


    public $product;
    public $qty;
    public function __construct(Product $product, $qty)
    {
        $this->product = $product;
        $this->qty = $qty;
    }
}
