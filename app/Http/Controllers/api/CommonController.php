<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Customer;
use App\Models\Review;
use App\Models\ProductFavourite;
use App\Http\Resources\ProductResource;
use App\Http\Resources\ProductFavouriteResource;
use App\Http\Resources\ReviewResource;

class CommonController extends Controller
{
    public function productFilter(Request $request)
    {
        if ($request->filled('searchText')) $perPage = $request->perPage;
        else $perPage = 8;

        if ($request->filled('page')) $page = $request->page;
        else $page = 1;

        $filterArrayTitle = [];
        if ($request->filled('searchText')) {
            $filteredText = $request->searchText;
            $filterArrayTitle[] = ['name', 'LIKE', '%' . $filteredText . '%'];
        }

        $products = Product::query()
            ->where($filterArrayTitle)
            ->with('media', 'product_type', 'reviews')
            ->latest()
            ->paginate($perPage, ['*'], 'page', $page);

        // return $this->sendResponse($products, "Data fetch successfully", 200);
        return ProductResource::collection($products);
    }

    public function productDetails($id)
    {
        $product = Product::findOrFail($id);
        return ProductResource::make($product->load(['media', 'product_type', 'reviews']))->success(true)->message("Product details fetch successfully");
    }

    public function productfavourite(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $customer = Customer::findOrFail($request->user()->id);
        $productFavourite = ProductFavourite::where('customer_id', $request->user()->id)->where('product_id', $id)->first();
        if ($productFavourite) {
            return $this->sendError("The product already added favourite list. ", [], 422);
        }
        ProductFavourite::create([
            'customer_id' => $customer->id,
            'product_id'  => $product->id,
        ]);
        return $this->sendResponse([], "The product update favourite list.", 200);
    }

    public function productFavoriteFilter(Request $request)
    {
        if ($request->filled('searchText')) $perPage = $request->perPage;
        else $perPage = 8;

        if ($request->filled('page')) $page = $request->page;
        else $page = 1;

        $filterArrayTitle = [];
        if ($request->filled('searchText')) {
            $filteredText = $request->searchText;
            $filterArrayTitle[] = ['name', 'LIKE', '%' . $filteredText . '%'];
        }

        // $products = Product::query()
        //     ->where($filterArrayTitle)
        //     ->with(["media", "product_type", "favourite" => function ($q) use ($customerId) {
        //         $q->where('product_favourites.customer_id', $customerId);
        //     }])
        //     ->latest()
        //     ->paginate($perPage, ['*'], 'page', $page);

        $productFavourite = ProductFavourite::query()
            ->with(["product" => function ($q) use ($filterArrayTitle) {
                $q->where($filterArrayTitle)->with('media', 'product_type');
            }])
            ->where('customer_id', $request->user()->id)
            ->latest()
            ->paginate($perPage, ['*'], 'page', $page);

        return ProductFavouriteResource::collection($productFavourite);
    }


    public function productReviewFilter(Request $request)
    {
        $query = Review::query()
            ->with(["product" => function ($q) {
                $q->with('media', 'product_type');
            }]);
        if ($request->order_by == 'latest') {
            $query->latest();
        }
        $review = $query->where('product_id', $request->product_id)
            ->paginate($request->perPage, ['*'], 'page', $request->page);

        return ReviewResource::collection($review);
    }

    public function productReview(Request $request)
    {
        $request->validate([
            'review'     => 'required',
            'rating'     => 'required|min:1|max:5',
            'product_id' => 'required',
        ]);

        $review = Review::where('product_id', $request->product_id)->where('customer_id', $request->user()->id)->first();

        if ($review) {
            return $this->sendError("You are already review in this product.", [], 422);
        }

        $input = $request->all();
        $input['customer_id'] = $request->user()->id;
        $review = Review::create($input);

        return $this->sendResponse($review, "Review successfully.", 201);
    }
}
