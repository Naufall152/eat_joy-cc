<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Recipe;
use App\Models\User;
use App\Models\SubscriptionOrder;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $totalUsers = User::count();
        $totalRecipes = Recipe::count();
        $totalBlogs = Blog::count();

        $paidUsers = User::whereIn('subscription_plan', ['starter', 'starter_plus'])->count();

        $recentUsers = User::latest()->take(6)->get(['id','username','email','subscription_plan','role','created_at']);
        $recentOrders = class_exists(SubscriptionOrder::class)
            ? SubscriptionOrder::latest()->take(6)->get()
            : collect([]);

        // simple summary orders by status (kalau tabel ada)
        $orderSummary = class_exists(SubscriptionOrder::class)
            ? SubscriptionOrder::select('status', DB::raw('COUNT(*) as total'))
                ->groupBy('status')->pluck('total','status')
            : collect([]);

        return view('admin.dashboard', compact(
            'totalUsers','totalRecipes','totalBlogs','paidUsers','recentUsers','recentOrders','orderSummary'
        ));
    }
}
