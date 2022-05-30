<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'mobile',
        'email_verfied',
        'mobile_verfied',
        'shipping_address',
        'billing_address',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];



    //user have many Orders
    // ONE to MANY Relationship
    // connecting models with each other to tell frame who is related to who
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function payment()
    {
        return $this->hasMany(Payment::class);
    }

    public function shipment()
    {
        return $this->hasMany(Shipment::class);
    }

    public function shippingAddress()
    {
        return $this->hasOne(Address::class, 'id', 'shipping_address');
    }

    public function billingAddress()
    {
        return $this->hasOne(Address::class, 'id', 'billing_address');
    }
    public function wishList()
    {
        return $this->hasOne(WishList::class);
    }
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
    public function roles(){
        return $this->belongsToMany(Role::class);
    }
    public function cart(){
        return $this->hasOne(Cart::class);
    }


    // in the view When you do $reviews->customer->formattedName,
    //you're trying to use Eloquent relationship which you don't have.
    // so u need to call it like this $reviews->customer->formattedName()
    public function formattedName(){
        return $this->first_name.' '.$this->last_name;
    }
}
