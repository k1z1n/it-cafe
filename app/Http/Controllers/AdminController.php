<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\StatisticVisit;
use App\Models\User;
use App\Models\Visit;
use Carbon\Carbon;
use Coduo\PHPHumanizer\NumberHumanizer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use NumberFormatter;

class AdminController extends Controller
{
    public function showProducts()
    {
        $products = Product::paginate(10);
        return view('admin.products', compact('products'));
    }

    public function searchProducts(Request $request)
    {
        $searchTerm = $request->input('search');
        $productsQuery = Product::query();

        if ($searchTerm) {
            $productsQuery->where(function ($query) use ($searchTerm) {
                $query->where('title', 'like', '%' . $searchTerm . '%')
                    ->orWhere('price', 'like', '%' . $searchTerm . '%');
            });
        }

        $products = $productsQuery->paginate(10)->withQueryString();
        $count = $products->total();

        return view('admin.products', compact('products', 'count'));
    }



    public function showOneProduct($id)
    {
        $product = Product::findOrFail($id);
        return view('admin.product-delete', compact('product'));
    }

    public function showCategories()
    {
        $categories = Category::paginate(10);
        return view('admin.categories', compact('categories'));
    }

    public function searchCategories(Request $request)
    {
        $searchTerm = $request->input('search');
        $categoriesQuery = Category::query();
        if ($searchTerm) {
            $categoriesQuery->where(function ($query) use ($searchTerm) {
                $query->where('title', 'like', '%' . $searchTerm . '%');
            });
        }
        $categories = $categoriesQuery->paginate(10)->withQueryString();
        $count = $categories->total();
        return view('admin.categories', compact('categories', 'count'))->render();
    }

    public function showOneCategory($id)
    {
        $category = Category::findOrFail($id);
        return view('admin.category-delete', compact('category'));
    }

    public function showUsers()
    {
        $users = User::all();
        return view('admin.users', compact('users'));
    }

    public function searchUsers(Request $request)
    {
        $searchTerm = $request->input('search');
        $usersQuery = User::query();
        if ($searchTerm) {
            $usersQuery->where(function ($query) use ($searchTerm) {
                $query->where('id', $searchTerm)
                    ->orWhere('phone_number', 'like', '%' . $searchTerm . '%')
                    ->orWhere('status', $searchTerm)
                    ->orWhere('role', $searchTerm)
                    ->orWhere('username', 'like', '%' . $searchTerm . '%');
            });
        }
        $users = $usersQuery->paginate(10)->withQueryString();
        $count = $users->total();
        return view('admin.users', compact('users', 'count'));
    }

    public function choiceCategory()
    {
        $categories = Category::all();
        return view('admin.product-create', compact('categories'));
    }

    public function createCategory()
    {
        return view('admin.category-create');
    }

    public function addProduct(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|min:2|max:200|unique:products,title',
            'description' => 'required|min:10',
            'price' => 'required|min:1|numeric',
            'count' => 'nullable|numeric',
            'weight' => 'nullable|numeric',
            'structure' => 'required|min:10',
            'category_id' => 'required|integer',
        ]);

        if ($request->hasFile('image_path')) {
            $image = $request->file('image_path');
            $title = uniqid() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('images');
            $image->move($destinationPath, $title);
            $validatedData['image_path'] = $title;
        }

        Product::create($validatedData);

        return redirect()->route('admin.product.index')->with('success', 'Продукт ' . $validatedData['title'] . ' успешно добавлен');
    }

    public function addCategory(Request $request)
    {
        $validatedDate = $request->validate([
            'title' => 'required|min:2|max:30|unique:categories,title'
        ]);

        Category::create($validatedDate);

        return redirect()->route('admin.category.index')->with('success', 'Категория ' . $validatedDate['title'] . ' успешно добавлена');
    }

    public function editProduct($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();
        return view('admin.product-update', compact('product', 'categories'));
    }

    public function updateProduct(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $validatedData = $request->validate([
            'title' => 'required|min:2|max:200|unique:products,title,' . $id,
            'description' => 'required|min:10',
            'price' => 'required|min:1|numeric',
            'count' => 'nullable|numeric',
            'weight' => 'nullable|numeric',
            'structure' => 'required|min:10',
            'category_id' => 'required|integer'
        ]);

        if ($request->hasFile('image_path')) {
            $imageName = time() . '_' . $request->file('image_path')->getClientOriginalName();
            $request->image_path->storeAs('imgss', $imageName);
            $validatedData['image_path'] = $imageName;
        }

        $product->update($validatedData);

        return redirect()->route('admin.product.index')->with('success', 'Продукт \'' . $validatedData['title'] . '\' успешно обновлен');
    }

    public function editCategory($id)
    {
        $category = Category::findOrFail($id);
        return view('admin.category-update', compact('category'));
    }

    public function updateCategory(Request $request, $id)
    {
        $validatedData = $request->validate([
            'title' => 'required|min:2|max:30|unique:categories,title,' . $id
        ]);

        $category = Category::findOrFail($id);
        $category->update($validatedData);
        return redirect()->route('admin.category.index')->with('success', 'Категория \'' . $validatedData['title'] . '\' успешно обновлена');
    }

    public function destroyProduct($id)
    {
        $product = Product::findOrFail($id);
        if ($product->image_path) {
            $oldPath = public_path('images') . '/' . $product->image_path;
            if (file_exists($oldPath)) {
                unlink($oldPath);
            }
        }
        $product->delete();
        return redirect()->route('admin.product.index')->with('success', 'Успешное удаление продукта');
    }

    public function destroyCategory($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();
        return redirect()->route('admin.category.index')->with('success', 'Успешное удаление категории');
    }

    public function updateRole(Request $request, User $user)
    {
        $validatedData = $request->validate([
            'role' => 'required|in:user,admin,cashier',
        ]);

        $user->role = $validatedData['role'];
        $user->save();

        return redirect()->back()->with('success', 'Роль пользователя успешно изменена.');
    }

    public function updateStatus(Request $request, User $user)
    {
        $validatedData = $request->validate([
            'status' => 'required|in:active,blocked',
        ]);

        $user->status = $validatedData['status'];
        $user->save();

        return redirect()->back()->with('success', 'Статус пользователя успешно изменен.');
    }

    public function showCarts()
    {
        $carts = CartItem::all();
        return view('admin.carts', compact('carts'));
    }

    public function showOrders(){
        $orders = Order::all();
        return view('admin.orders', compact('orders'));
    }


    public function main()
    {
        $weeklyVisits = StatisticVisit::whereBetween('date', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
            ->get()
            ->map(function ($visit) {
                // Получаем день недели из даты
                $visit->dayOfWeek = Carbon::parse($visit->date)->dayName;
                return $visit;
            });

        // Получаем статистику за сегодня
        $dailyVisits = StatisticVisit::where('date', Carbon::now()->toDateString())->first();
        $productsCount = NumberHumanizer::metricSuffix(Product::all()->count());
        $usersCount = NumberHumanizer::metricSuffix(User::all()->count());
        $totalDeliveredOrders = NumberHumanizer::metricSuffix(Order::where('status', 'доставлено')->sum('total'));
        $totalVisits = NumberHumanizer::metricSuffix(Visit::sum('quantity'));
        return view('admin.main', compact('productsCount', 'usersCount', 'totalDeliveredOrders', 'totalVisits', 'weeklyVisits', 'dailyVisits'));
    }

    public function userStat()
    {
        $users = Visit::paginate(10);
        return view('admin.statistic-users', compact('users'));
    }

    public function ordersStat() {

        $popularProductsByMonth = OrderItem::select(DB::raw('YEAR(orders.created_at) as year, MONTH(orders.created_at) as month, product_id, COUNT(*) as total_orders'))
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->groupBy('year', 'month', 'product_id')
            ->orderBy('year', 'asc')
            ->orderBy('month', 'asc')
            ->get();

        return view('admin.statistic-orders', compact('popularProductsByMonth'));
    }

}
