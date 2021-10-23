<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'payment_id',
        'cart_id',
        'order_date'
    ];


    public function customer(){
        return $this->belongsTo(User::class);
    }
    public function cart(){
        return $this->hasOne(Cart::class);
    }
    public function payment(){
        return $this->hasOne(Payment::class);
    }
}
