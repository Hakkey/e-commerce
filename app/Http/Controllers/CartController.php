<?php

namespace App\Http\Controllers;

use App\Order;
use App\OrderItem;
use App\Transaction;
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
        $order = Order::where('reference_no', '!=', null)->first();

        return view('cart', compact('orderItems', 'order'));
    }

    public function storecart(Request $request, $id){

        $price = $request->price;
        $name = $request->name;
        $quantity = 1;
        $order_items = OrderItem::all();
        $order = Order::all();

        if(count($order) > 0)
        {
            $order_id = Order::where('reference_no', '!=', null)->first()->id;
            if(count($order_items) > 0){
                if(OrderItem::where('item_id', '=', $id)->count() > 0)
                {
                    $get_quantity = OrderItem::where('item_id', '=', $id)->first()->quantity;
    
                    $update_item = OrderItem::where('item_id', '=', $id)->update(array('quantity' => $get_quantity + 1));
                }
                else{
                    OrderItem::create([
                        'item_id' => $id,
                        'order_id' => $order_id,
                        'cost_per_item' => $price,
                        'product_name' => $name,
                        'quantity' => $quantity,
                    ]);
                }
                    
            }
        }
        
        else{

            $order = new Order();
            $random_number = rand();
            $order->reference_no = $random_number;
            $order->save();

            $order_item = new OrderItem;
            $order_item->item_id = $id;
            $order_item->order_id = $order->id;
            $order_item->product_name = $name;
            $order_item->cost_per_item = $price;
            $order_item->quantity = $quantity;
            $order_item->save();

            $order_item = new Transaction;
            $order_item->order_id = $order->id;
            $order_item->save();
        }

        // if(count($order_items) > 0){
        //     if(OrderItem::where('item_id', '=', $id)->count() > 0)
        //     {
        //         $get_quantity = OrderItem::where('item_id', '=', $id)->first()->quantity;

        //         $update_item = OrderItem::where('item_id', '=', $id)->update(array('quantity' => $get_quantity + 1));
        //     }
        //     else{
        //         OrderItem::create([
        //             'item_id' => $id,
        //             'order_id' => 0,
        //             'cost_per_item' => $price,
        //             'product_name' => $name,
        //             'quantity' => $quantity,
        //         ]);
        //     }
                

        //     // dd('not null');
        // }
        // else{
        //     OrderItem::create([
        //         'item_id' => $id,
        //         'order_id' => 0,
        //         'cost_per_item' => $price,
        //         'product_name' => $name,
        //         'quantity' => $quantity,
        //     ]);

        // }

        
        
    }

    
    public function updatequantity(Request $request, $id)
    {
        $quantity = $request->quantity;

        OrderItem::where('item_id', '=', $id)->update(array('quantity' => $quantity));
    }

    public function storeorder(Request $request, $reference_no)
    {

        $tax = $request->tax;
        $total_amount_cents = $request->total_amount_cents;
        $order_status = $request->order_status;

        $order_id = $request->order_id;
        $reference_no = $request->reference_no;
        $transaction_status = $request->transaction_status;
        $payment_method = $request->payment_method;
        $paid_amount_cents = $request->paid_amount_cents;


        Order::where('reference_no', '=', $reference_no)->update(
            array(
             'tax' => $tax, 
             'total_amount_cents' => $total_amount_cents,
             'status' => $order_status
            ));

        Transaction::where('order_id', '=', $order_id)->update(
            array(
            'payment_method' => $payment_method,
            'status' => $transaction_status,
            'paid_amount_cents' => $paid_amount_cents
            ));
        
    }

    public function removeorder($id)
    {
        OrderItem::where('item_id', '=', $id)->delete();
    }

    public function summaryorder($id){

        $order = Order::find($id);
        $transaction = Transaction::find($id);

        return view('summary', ['orderItems'=>$order->orderitems, 'transaction'=>$transaction]);

    }

    public function neworder($id){

        Transaction::where('order_id', '=', $id)->delete();
        OrderItem::where('order_id', '=', $id)->delete();
        Order::where('id', '=', $id)->delete();

    }
}
