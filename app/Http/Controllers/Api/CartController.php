<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CartResource;
use App\Http\Resources\ProductResource;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{

    public function index()
    {
        $user = Auth::user();
        $cart = $user->cart;
        $cartItems = json_decode($cart->cart_items);
        $finalCartItems = [];
        foreach ($cartItems as $cartItem) {

            $product = Product::find(intval($cartItem->product->id));
            $finalcartItem = new \stdClass();
            $finalcartItem->product = new ProductResource($product);
            $finalcartItem->qty = number_format(doubleval($cartItem->qty), 2);
            array_push($finalCartItems, $finalcartItem);
        }
        return [
            'cart_items' => $finalCartItems,
            'id' => $cart->id,
            'total' => $cart->total,
        ];
    }

    public function addProductToCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required',
            'qty' => 'required',
        ]);
        //Get the Authenticated user
        $user = Auth::user();

        // get product wanted to add always = 1
        $qty = $request->input('qty');

        //Get the product wanted to add from request
        $product_id = $request->input('product_id');
        $product = Product::findorFail($product_id);


        //get user cart by checking if card is empty if so create new one
        // $cart = $this->checkCartStatus($user->cart);

        $cart = $user->cart;
        if (is_null($cart)) {
            $cart = new Cart();
            $cart->user_id = $user->id;
            $cart->cart_items = [];
            $cart->total = 0;
        }


        //check if product already in cart by fucntions in CART MODEL CLASS
        if ($cart->inItems($product_id)) {
            // if exists increase qty
            $cart->increaseProductInCart($product, $qty);
        } else {
            //Add Product to Cart
            $cart->addProductToCart($product, $qty);
        }
        // save cart

        $cart->save();
        $user->cart_id = $cart->id;
        $user->save();
        return $cart;

        // return api response to client
        // return new CartResource($cart);
    }

    public function removeProductFromCart($id)
    {
        $product = Product::find($id);

        //Get the Authenticated user
        $user = Auth::user();



        $cart = $user->cart;
        if (is_null($cart)) {
            $cart = new Cart();
            $cart->user_id = $user->id;
            $cart->cart_items = [];
            $cart->total = 0;
        }


        //check if product already in cart by fucntions in CART MODEL CLASS
        if ($cart->inItems($id)) {
            // if exists increase qty
            $cart->decreaseProduct($product);
        }
        // save cart

        $cart->save();
        $user->cart_id = $cart->id;
        $user->save();
        return $cart;
    }
}
