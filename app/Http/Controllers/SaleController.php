<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Product;
use Illuminate\View\View;
use Illuminate\Http\Request;


class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sales = Sale::orderByDesc('created_at')->get();
        $products = Product::all();

        foreach ($sales as $key => $sale) {
            foreach($products as $p_key => $product) {
                if ($product['id'] === $sale['product_id']) {
                    $sales[$key]['name'] = $product['name'];
                }
            }

            $sales[$key]['sale_date_time'] = $sale['created_at']->format('Y-m-d h:i');
        }

        return view('pages.sales', [
            'sales' => $sales,
            'products' => $products,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $sale = new Sale;

        $sale->product_id = $request->product_id;
        $sale->quantity = $request->quantity;
        $sale->unit_cost = $request->unit_cost;

        return $sale->save();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Sale $sale)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sale $sale)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Sale $sale)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sale $sale)
    {
        //
    }
}
