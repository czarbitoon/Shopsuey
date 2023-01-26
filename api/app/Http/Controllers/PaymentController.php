<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\Order;
use App\Models\Product;
use Auth;
class PaymentController extends Controller
{
    public function checkout(Request $request, $product_id)
    {
        $lineItems = [];
        $user = Auth::user();
        $product = Product::find($product_id);

        if(!$product){
            return response()->json([
                'message' => 'Product not found'
            ], 404);
        }

        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET_KEY'));

        $lineItems[] =
            [
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' =>[
                        'name' => $product->name,
                    ],
                    'unit_amount' => $product->price * 100,
                ],
                    'quantity' => 1,
            ];

        $session = \Stripe\Checkout\Session::create([
            'payment_method_types' => ['card'],
            'customer_email' => $user->email,
            'line_items' => $lineItems,
            'mode' => 'payment',
            'success_url' => env('APP_URL') . '/success?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => env('APP_URL') . '/cancel',
        ]);

        $order = new Order();
        $order->user_id = $user->id;
        $order->status = 'unpaid';
        $order->total_price = $product->price;
        $order->session_id = $session->id;
        $order->save();

        return response()->json([
            'url' => $session->id
        ], 200);
    }

    public function success(Request $request)
    {
        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET_KEY'));
        $session_id = $request->get('session_id');
        $order = Order::where('session_id', $session_id)->first();

        $session = $stripe->checkout->sessions->retrieve($session_id);
        if(!$session){
            return response()->json([
                'message' => 'Session not found',
            ], 404);
        }

        if(!$order){
            $user = Auth::user();
            $user->product_id = null;
            $user->save();
        }

        if(!$order->status == 'unpaid'){
            $order->status = 'paid';
            $order->save();

        }

        $payment = new Payment();
        $payment->order_id = $order->id;
        $payment->st_cus_id = $session->customer;
        $payment->st_payment_intent_id = $session->payment_intent;
        $payment->st_payment_method = $session->payment_method_types[0];
        $payment->status = $session->payment_status;
        $payment->date = $session->created;
        $payment->save();

        return response()->json([
            'message' => 'Order paid Successfully'
        ], 200);
    }

}
