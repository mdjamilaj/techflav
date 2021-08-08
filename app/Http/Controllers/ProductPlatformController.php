<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductPlatform;

class ProductPlatformController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:productPlatform-list|productPlatform-create|productPlatform-edit|productPlatform-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:productPlatform-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:productPlatform-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:productPlatform-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $data = ProductPlatform::latest()->paginate(5);
        return view('productPlatform.index', compact('data'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    public function create()
    {
        return view('productPlatform.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'details' => 'required',
        ]);

        $input = $request->all();
        $productPlatform = ProductPlatform::create($input);

        return redirect()->route('productPlatform.index')
            ->with('success', 'Product platform created successfully.');
    }

    public function edit(ProductPlatform $productPlatform)
    {
        $data = $productPlatform;
        return view('productPlatform.edit', compact('data'));
    }

    public function update(Request $request, ProductPlatform $productPlatform)
    {
        $request->validate([
            'name' => 'required',
            'details' => 'required',
        ]);

        $input = $request->all();
        $productPlatform->update($input);
        return redirect()->route('productPlatform.index')
            ->with('success', 'Product platform updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProductPlatform $productPlatform)
    {
        $productPlatform->delete();

        return redirect()->route('productPlatform.index')
            ->with('success', 'Product platform deleted successfully');
    }
}
