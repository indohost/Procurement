<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Vendor;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

class ManagementController extends Controller
{
    private $unitProducts;
    private $categoryProducts;

    private $vendor;
    private $product;

    public function __construct()
    {
        $unitProducts = config('general.unit_product');
        sort($unitProducts);
        $this->unitProducts = $unitProducts;

        $categoryProducts = config('general.category_product');
        sort($categoryProducts);
        $this->categoryProducts = $categoryProducts;

        $this->vendor = new Vendor();
        $this->product = new Product();
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->ajax()) {
            $authUser = Auth::user();
            $userVendor = $this->vendor
                ->where('user_id', $authUser->id)
                ->first();

            if (!$userVendor)
                return response()->json([
                    'data' => [],
                    'recordsTotal' => 0,
                    'recordsFiltered' => 0,
                ]);

            $products = $this->product->query()->where('vendor_id', $userVendor->id);

            return DataTables::of($products)
                ->addColumn('action', function ($product) {
                    return view('product-management.action', [
                        'id' => $product->id,
                    ]);
                })

                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }

        return view('product-management.index', [
            'title' => 'Management Product',
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('product-management.create', [
            'title' => 'Daftar Product',
            'unitProducts' => $this->unitProducts,
            'categoryProducts' => $this->categoryProducts,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:products,name',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'unit_stock' => ['required', 'string', Rule::in($this->unitProducts)],
            'category' => ['required', 'string', Rule::in($this->categoryProducts)],
            'description' => 'required|string',
        ]);

        try {
            $authUser = Auth::user();
            $userVendor = $this->vendor
                ->where('user_id', $authUser->id)
                ->first();

            if (!$userVendor) return redirect()->route('product-management.index')
                ->with('status', ['type' => 'danger', 'message' => __("Akun Anda tidak terafiliasi ke Vendor yang telah terdaftar.")]);

            $requestProduct = [
                'name' => $request->name,
                'price' => $request->price,
                'stock' => $request->stock,
                'unit_stock' => $request->unit_stock,
                'category' => $request->category,
                'description' => $request->description,
                'vendor_id' => $userVendor->id,
            ];

            $product = $this->product->create($requestProduct);

            if ($product) return redirect()->route('product-management.index')
                ->with('status', ['type' => 'success', 'message' => __("Penambahakan produk berhasil.")]);
        } catch (Exception $e) {
            Log::error([
                'title' => 'added product',
                'message'   => $e->getMessage(),
            ]);

            return redirect()->route('product-management.index')
                ->with('status', ['type' => 'danger', 'message' => __("Penambahakan produk belum berhasil. Silahkan hubungi Admin.")]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = $this->product
            ->find($id);

        return view('product-management.show', [
            'title' => 'Product Details',
            'product' => $product,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $product = $this->product
            ->find($id);

        return view('product-management.edit', [
            'title' => 'Perubahan Product',
            'product' => $product,
            'unitProducts' => $this->unitProducts,
            'categoryProducts' => $this->categoryProducts,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'string|unique:products,name',
            'price' => 'numeric',
            'stock' => 'integer',
            'unit_stock' => ['string', Rule::in($this->unitProducts)],
            'category' => ['string', Rule::in($this->categoryProducts)],
            'description' => 'string',
        ]);

        try {
            $requestProduct = [
                'name' => $request->name,
                'price' => $request->price,
                'stock' => $request->stock,
                'unit_stock' => $request->unit_stock,
                'category' => $request->category,
                'description' => $request->description,
            ];

            $product = $this->product->find($id);
            $product->update($requestProduct);

            if ($product) return redirect()->route('product-management.index')
                ->with('status', ['type' => 'success', 'message' => __("Perubahan produk berhasil.")]);
        } catch (Exception $e) {
            Log::error([
                'title' => 'added product',
                'message'   => $e->getMessage(),
            ]);

            return redirect()->route('product-management.index')
                ->with('status', ['type' => 'danger', 'message' => __("Perubahan produk belum berhasil. Silahkan hubungi Admin.")]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $product = $this->product
                ->findOrFail($id);

            $product->delete();

            if ($product) return redirect()->route('product-management.index')
                ->with('status', ['type' => 'success', 'message' => __("Delete produk berhasil.")]);
        } catch (Exception $e) {
            Log::error([
                'title' => 'delete product',
                'message'   => $e->getMessage(),
            ]);

            return redirect()->route('product-management.index')
                ->with('status', ['type' => 'danger', 'message' => __("Delete produk belum berhasil. Silahkan hubungi Admin.")]);
        }
    }
}
