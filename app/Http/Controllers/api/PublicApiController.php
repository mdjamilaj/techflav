<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Contact;
use App\Models\ProductType;
use App\Models\ProductCategory;
use App\Models\ProductPlatform;
use App\Http\Resources\ProductPublicResource;
use App\Http\Resources\ProductTypeResource;
use App\Http\Resources\ProductCategoryResource;
use App\Rules\Recaptcha;
use PHPUnit\Framework\Constraint\Count;

class PublicApiController extends Controller
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

        $filterArraySearchType = [];
        if ($request->filled('productSearchType')) {
            if ($request->productSearchType == 'top_sale') {
                $filterArraySearchType[] = ['is_topsale', '=', 1];
            } elseif ($request->productSearchType == 'featured') {
                $filterArraySearchType[] = ['is_featured', '=', 1];
            }
        }


        $filterTypeSearchType = [];
        if ($request->filled('type') && $request->type) {
            $filterTypeSearchType[] = ['product_type_id', '=', $request->type];
        }

        $query = Product::query()
            ->where($filterArrayTitle)
            ->where($filterArraySearchType)
            ->where($filterTypeSearchType);

        if ($request->filled('category') && $request->category && count($request->category) > 0) {
            $query = $query->whereIn('product_category_id', $request->category);
        }
        if ($request->filled('platform') && $request->platform && count($request->platform) > 0) {
            $query = $query->whereIn('product_platform_id', $request->platform);
        }
        $products =   $query->with('media', 'product_type', 'product_category', 'product_platform', 'favourite', 'reviews')
            ->withCount('reviews')
            ->latest()
            ->paginate($perPage, ['*'], 'page', $page);

        // return $this->sendResponse($products, "Data fetch successfully", 200);
        return ProductPublicResource::collection($products);
    }

    public function productGetByIds(Request $request)
    {
        $products = Product::whereIn('id', $request->ids)
            ->with('media', 'product_type', 'product_category', 'product_platform', 'favourite', 'reviews')
            ->withCount('reviews')
            ->latest()
            ->get();
        return ProductPublicResource::collection($products);
    }

    public function productType()
    {
        $productType = ProductType::get();
        return ProductTypeResource::collection($productType);
    }

    public function productTypeDetails($id)
    {
        $productType = ProductType::findOrFail($id);
        return ProductTypeResource::make($productType);
    }

    public function productCategory()
    {
        $productCategory = ProductCategory::latest()->get();
        return ProductCategoryResource::collection($productCategory);
    }

    public function productPlatform()
    {
        $productPlatform = ProductPlatform::latest()->get();
        return $this->sendResponse($productPlatform, "Data fetch successfully", 200);
    }
    public function contact(Request $request, Recaptcha $recaptcha)
    {
        $request->validate([
            'first_name' => 'required|min:3|string|max:255',
            'email' => 'required|string|email|max:255',
            'message' => 'required|min:30|max:1000',
            'subject' => 'required',
            'recaptcha' => ['required', $recaptcha],
        ]);

        try {
            $input = $request->all();
            unset($input['recaptcha']);
            $contact = Contact::create($input);
            return $this->sendResponse($contact, "Message sent successful", 200);
        } catch (\Throwable $th) {
            return $this->sendError($th->getMessage(), [], 500);
        }
    }
}
