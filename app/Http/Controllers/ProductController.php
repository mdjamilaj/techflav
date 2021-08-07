<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductPlatform;
use Illuminate\Http\Request;
use App\Models\ProductType;
use App\Models\ProductCategory;
use File;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:product-list|product-create|product-edit|product-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:product-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:product-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:product-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Product::with('media')->latest()->paginate(5);
        return view('products.index', compact('data'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $last_product = Product::latest()->first();
        if($last_product) $last_product_id = $last_product->id + 1;
        else $last_product_id = 1;
        $product_types = ProductType::all();
        $product_categories = ProductCategory::all();
        $product_platforms = ProductPlatform::all();
        $licence_key = $last_product_id.'-'.$this->generateRandomString(20);
        return view('products.create', compact('product_types','product_categories', 'product_platforms', 'licence_key'));
    }


    public function generateRandomString($length = 25) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'details' => 'required',
            'product_price_type' => 'required',
            'product_type_id' => 'required',
            'product_category_id' => 'required',
            'product_platform_id' => 'required',
            'file_included' => 'required',
            'licence_key' => 'required|string|unique:products,licence_key,NULL,id,deleted_at,NULL',
            'cover_photo' => 'required',
            'cover_photo.*' => 'mimes:jpeg,jpg,png,webp',
            'product' => 'required|mimes:zip',
        ]);

        if ($request->product_price_type == 'paid') {
            $request->validate([
                'price' => 'required|numeric',
                'discount_price' => 'nullable|numeric',
            ]);
        }

        $input = $request->all();
        unset($input['cover_photo']);
        unset($input['product']);
        unset($input['product_and_documentation']);
        if ($input['is_discount_percentage'] == true)  $input['is_discount_percentage'] = 1;
        else $input['is_discount_percentage'] = 0;
        $product = Product::create($input);

        if ($request->hasFile('cover_photo')) {
            foreach ($request->file('cover_photo') as $attachment) {
                // $media = $product->addMedia($request->cover_photo)->toMediaCollection("product-gallery");
                // $product->cover_photo_id = $media->id;
                // $product->save();
                $product->addMedia($attachment)->toMediaCollection("product-gallery");
            }
        }

        if ($request->hasFile('product')) {
            $product->addMedia($request->file('product'))->toMediaCollection("product-download");
        }

        if ($request->hasFile('product_and_documentation')) {
            $product->addMedia($request->file('product_and_documentation'))->toMediaCollection("product-and-documentation-download");
        }

        return redirect()->route('products.index')
            ->with('success', 'Product created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::with('media')->find($id);
        return view('products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $data = $product;
        $product_types = ProductType::all();
        $product_categories = ProductCategory::all();
        $product_platforms = ProductPlatform::all();
        return view('products.edit', compact('data', 'product_types', 'product_categories', 'product_platforms'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required',
            'details' => 'required',
            'product_category_id' => 'required',
            'product_platform_id' => 'required',
            'file_included' => 'required',
            'licence_key' => 'required|string|unique:products,licence_key,NULL,id,deleted_at,NULL'.$product->id,
            'price' => 'required|numeric',
            'discount_price' => 'nullable|numeric',
            'cover_photo.*' => 'mimes:jpeg,jpg,png,webp',
            'product' => 'mimes:zip',
        ]);

        $input = $request->all();
        unset($input['cover_photo']);
        unset($input['product']);
        unset($input['product_and_documentation']);
        if ($input['is_discount_percentage'] == true)  $input['is_discount_percentage'] = 1;
        else $input['is_discount_percentage'] = 0;
        $product->update($input);
        if ($request->hasFile('cover_photo')) {
            foreach ($request->file('cover_photo') as $attachment) {
                $product->addMedia($attachment)->toMediaCollection("product-gallery");
            }
        }

        if ($request->hasFile('product')) {
            $product->addMedia($request->file('product'))->toMediaCollection("product-download");
        }

        if ($request->hasFile('product_and_documentation')) {
            $product->addMedia($request->file('product_and_documentation'))->toMediaCollection("product-and-documentation-download");
        }

        return redirect()->route('products.index')
            ->with('success', 'Product updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('products.index')
            ->with('success', 'Product deleted successfully');
    }
}
