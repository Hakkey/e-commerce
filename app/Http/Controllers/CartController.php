<?php

namespace App\Http\Controllers;


use App\OrderItem;
use Illuminate\Http\Request;
use Melihovv\ShoppingCart\Facades\ShoppingCart as Cart;

class CartController extends Controller
{
    
    private $order_items = [];

    public static function getCartCount()
    {
        $cart_count = OrderItem::all()->count();
        return $cart_count;
    }

    public function index()
    {
        return view('shop');
    }

    public function viewCart()  
    {
        $orderItems = OrderItem::all();

        return view('cart', compact('orderItems'));
    }

    public function storecart(Request $request, $id){

        $price = $request->price;
        $name = $request->name;
        $quantity = 1;
        $order_items = OrderItem::all();


        if(count($order_items) > 0){
            if(OrderItem::where('item_id', '=', $id)->count() > 0)
            {
                $get_quantity = OrderItem::where('item_id', '=', $id)->first()->quantity;

                $update_item = OrderItem::where('item_id', '=', $id)->update(array('quantity' => $get_quantity + 1));
            }
            else{
                OrderItem::create([
                    'item_id' => $id,
                    'order_id' => 0,
                    'cost_per_item' => $price,
                    'product_name' => $name,
                    'quantity' => $quantity,
                ]);
            }
                

            // dd('not null');
        }
        else{
            OrderItem::create([
                'item_id' => $id,
                'order_id' => 0,
                'cost_per_item' => $price,
                'product_name' => $name,
                'quantity' => $quantity,
            ]);

        }
        
    }

    
    public function updatequantity(Request $request, $id)
    {
        $quantity = $request->quantity;

        OrderItem::where('item_id', '=', $id)->update(array('quantity' => $quantity));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function removeorder($id)
    {
        OrderItem::where('item_id', '=', $id)->delete();
    }
}
