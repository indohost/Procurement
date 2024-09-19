<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CatalogController extends Controller
{
    private $product;

    public function __construct()
    {
        $this->product = new Product();
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->ajax()) {
            $products = $this->product::query();

            return DataTables::of($products)
                ->addColumn('action', function ($product) {
                    return view('product-catalog.action', [
                        'id' => $product->id,
                    ]);
                })

                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }

        return view('product-catalog.index', [
            'title' => 'Product Catalog',
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = $this->product
            ->find($id);

        return view('product-catalog.show', [
            'title' => 'Product Details',
            'product' => $product,
        ]);
    }
}
