<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductType;
use App\Models\ProductCategory;
use App\Models\ProductPlatform;
use App\Http\Resources\ProductPublicResource;
use App\Http\Resources\ProductTypeResource;
use App\Http\Resources\ProductCategoryResource;

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


        $products = Product::query()
            ->where($filterArrayTitle)
            ->where($filterArraySearchType)
            ->with('media', 'product_type', 'product_category', 'product_platform', 'favourite', 'reviews')
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
        $productType = ProductType::latest()->get();
        return ProductTypeResource::collection($productType);
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
}
