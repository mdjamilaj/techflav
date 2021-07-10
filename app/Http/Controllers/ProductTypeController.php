<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductType;

class ProductTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:productType-list|productType-create|productType-edit|productType-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:productType-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:productType-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:productType-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $data = ProductType::latest()->paginate(5);
        return view('productTypes.index', compact('data'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    public function create()
    {
        return view('productTypes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'details' => 'required',
        ]);

        $input = $request->all();
        $productType = ProductType::create($input);

        return redirect()->route('productTypes.index')
            ->with('success', 'Product type created successfully.');
    }

    public function edit(ProductType $productType)
    {
        $data = $productType;
        return view('productTypes.edit', compact('data'));
    }

    public function update(Request $request, ProductType $productType)
    {
        $request->validate([
            'name' => 'required',
            'details' => 'required',
        ]);

        $input = $request->all();
        $productType->update($input);
        return redirect()->route('productTypes.index')
            ->with('success', 'Product type updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProductType $productType)
    {
        $productType->delete();

        return redirect()->route('productTypes.index')
            ->with('success', 'Product type deleted successfully');
    }
}
