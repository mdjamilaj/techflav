<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Review;
use Auth;
use Redirect;

class ReviewController extends Controller
{
  
    function __construct()
    {
        $this->middleware('permission:review-list|review-create|review-edit|review-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:review-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:review-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:review-delete', ['only' => ['destroy']]);
    }

    public function index($product_id)
    {
        $product = Product::find($product_id);
        $data = Review::with('product', 'customer', 'admin')->latest()->paginate(5);
        return view('review.index', compact('data', 'product'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    public function create($product_id)
    {
        $customers = Customer::all();
        $product = Product::find($product_id);
        return view('review.create', compact('product', 'customers'));
    }

    public function store(Request $request, $product_id)
    {
        $request->validate([
            'customer' => 'required|exists:customers,id',
            'review' => 'required',
            'rating' => 'required|min:1|max:5'
        ]);

        $review = Review::where('product_id', $product_id)->where('customer_id', $request->customer)->first();

        if ($review) {
            return back()->withInput($request->all())->withErrors(['customer' => ['The customer already review in this product.']]);
        }


        $input = $request->all();
        unset($input['customer']);
        $input['customer_id'] = $request->customer;
        $input['user_id'] = Auth::user()->id;
        $input['product_id']  = $product_id;
        $review = Review::create($input);

        return redirect()->route('review.index', $product_id)
            ->with('success', 'Review successfully.');
    }

    public function show($id, $product_id)
    {
        $product = Product::with('media')->find($product_id);
        $data = Review::with('customer')->find($id);
        return view('review.show', compact('data', 'product'));
    }

    public function edit($id, $product_id)
    {
        $data = Review::with('customer')->find($id);
        $customers = Customer::all();
        $product = Product::find($product_id);
        return view('review.edit', compact('data', 'customers', 'product'));
    }

    public function update(Request $request, $id, $product_id)
    {
        $review = Review::find($id);
        $request->validate([
            'customer' => 'required|exists:customers,id',
            'review' => 'required',
            'rating' => 'required|min:1|max:5'
        ]);

        $input = $request->all();
        unset($input['customer']);
        $input['customer_id'] = $request->customer;
        $input['user_id'] = Auth::user()->id;
        $review->update($input);
        
        return redirect()->route('review.index', $product_id)
            ->with('success', 'Review updated successfully');
    }

    public function destroy($id, $product_id)
    {
        $review = Review::find($id);
        $review->delete();

        return redirect()->route('review.index', $product_id)
            ->with('success', 'Review deleted successfully');
    }
}
