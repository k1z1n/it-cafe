<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MainController extends Controller
{
    public function index()
    {
        $currentMonth = now()->month;

        $popularProductsCurrentMonth = OrderItem::select('product_id', DB::raw('COUNT(*) as total_orders'))
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->whereMonth('orders.created_at', '=', $currentMonth) // Фильтруем по текущему месяцу
            ->groupBy('product_id')
            ->orderByDesc('total_orders')
            ->limit(6) // Ограничиваем количество записей до 6
            ->get();
        $categories = Category::all();
        $products = Product::all();
        return view('home', compact('categories', 'products', 'popularProductsCurrentMonth'));
    }

}
