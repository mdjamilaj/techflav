<?php

namespace App\Http\Controllers;
use App\Models\Product;
use App\Models\Customer;
use App\Models\Review;
use Carbon\Carbon;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $data['total_product']      = Product::count();
        $data['last_month_product'] = Product::where(
            'created_at', '>=', Carbon::now()->subDays(30)->toDateTimeString()
        )->count();
        $data['total_customer']      = Customer::count();
        $data['last_month_customer'] = Customer::where(
            'created_at', '>=', Carbon::now()->subDays(30)->toDateTimeString()
        )->count();
        $data['total_review']      = Review::count();
        $data['last_month_review'] = Review::where(
            'created_at', '>=', Carbon::now()->subDays(30)->toDateTimeString()
        )->count();
        return view('dashboard', compact('data'));
    }
}
