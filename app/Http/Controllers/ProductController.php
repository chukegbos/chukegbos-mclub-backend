<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Type;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Log;
use App\Models\Club;
use Validator;
use GuzzleHttp\Client;
use Auth;

class ProductController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Product::with('types')->where('deleted_at', NULL)->latest();

        if ($request->payment_type) {
            $query->where('payment_type', $request->payment_type);
        }
        
        if ($request->keyword) {
            $query->where('name', 'like', '%' . $request->keyword . '%');
        }

        $success = $query->paginate(20);

        if($success){ 
            return $this->sendResponse($success, 'Payment products fetched successfully.');
        } 
        else{ 
            return $this->sendError('Not Fetched.', ['error'=>'Payment products could not be fetched, try again.']);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'amount' => 'required',
        ]);
        
        $product = Product::create([
            'name' => ucwords($request->name),
            'amount' => $request->amount,
            'door_access' => $request->door_access,
            'grace_period' => $request->grace_period,
            'reoccuring_day' => ($request->payment_type==1) ? $request->reoccuring_day : NULL,
            'payment_type' => $request->payment_type,
        ]);

        $product->types()->attach($request->member_type);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
    }
}
