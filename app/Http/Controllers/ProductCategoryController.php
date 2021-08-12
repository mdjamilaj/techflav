<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductCategory;

class ProductCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:productCategory-list|productCategory-create|productCategory-edit|productCategory-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:productCategory-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:productCategory-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:productCategory-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $data = ProductCategory::with('media')->latest()->paginate(10);
        return view('productCategory.index', compact('data'))
            ->with('i', (request()->input('page', 1) - 1) * 10);
    }

    public function create()
    {
        return view('productCategory.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'details' => 'required',
        ]);

        if ($request->hasFile('photo')) {
            $request->validate([
                'photo' => 'mimes:svg,png',
            ]);
        }

        $input = $request->all();
        unset($input['photo']);
        $productCategory = ProductCategory::create($input);

        if ($request->hasFile('photo')) {
            $productCategory->addMedia($request->file('photo'))->toMediaCollection("productcategory-photo");
        }

        return redirect()->route('productCategory.index')
            ->with('success', 'Product category created successfully.');
    }

    public function edit(ProductCategory $productCategory)
    {
        $data = $productCategory;
        return view('productCategory.edit', compact('data'));
    }

    public function update(Request $request, ProductCategory $productCategory)
    {
        $request->validate([
            'name' => 'required',
            'details' => 'required',
        ]);

        if ($request->hasFile('photo')) {
            $request->validate([
                'photo' => 'mimes:svg,png',
            ]);
        }

        $input = $request->all();
        unset($input['photo']);
        $productCategory->update($input);

        if ($request->hasFile('photo')) {
            $productCategory->addMedia($request->file('photo'))->toMediaCollection("productcategory-photo");
        }
        return redirect()->route('productCategory.index')
            ->with('success', 'Product category updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProductCategory $productCategory)
    {
        $productCategory->delete();

        return redirect()->route('productCategory.index')
            ->with('success', 'Product category deleted successfully');
    }
}
