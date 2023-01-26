<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{


    public function createProduct(Request $request)
    {
        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET_KEY'));

        $product = \Stripe\Product::create([
            'name' => $request->name,
            'type' => 'good',
        ]);

        $price = \Stripe\Price::create([
            'unit_amount' => $request->price * 100,
            'product' => $product->id,
            'currency' => 'usd',
        ]);

        $newProduct = new Product();
            $newProduct->st_product_id = $product->id;
            $newProduct->name = $request->name;
            $newProduct->genre = $request->genre;
            $newProduct->description = $request->description;
            $newProduct->price = $request->price;
            $newProduct->lookup_key = strtolower(str_replace(' ', '_', $request->name));
            $newProduct->save();

        return response()->json([
            'status' => true,
            'data' => $newProduct,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getProducts()
    {
        $product = Product::all();
        return response()->json([
            'status' => true,
            'data' => $product,
        ]);
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
    public function destroy(Request $request, $id)
    {
        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET_KEY'));
        $product = \Stripe\Product::retrieve($product_id);
        $product->delete();
    }
}
