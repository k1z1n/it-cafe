<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\DeliveryAddress;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        // Получаем все заказы
        $orders = Order::all();

        // Передаем данные в представление
        return view('orders.index', compact('orders'));
    }

    public function create()
    {
        // Проверяем, что пользователь авторизован
        if (auth()->check()) {
            // Получаем ID текущего пользователя
            $userId = auth()->id();

            // Получаем товары в корзине пользователя
            $cartItems = CartItem::with('product')->where('user_id', $userId)->get();

            // Если корзина пуста, перенаправляем на страницу корзины
            if ($cartItems->isEmpty()) {
                return redirect()->route('cart')->with('error', 'Ваша корзина пуста.');
            }

            // Возвращаем представление с формой оформления заказа
            return view('orders.create', compact('cartItems'));
        } else {
            // Если пользователь не авторизован, перенаправляем на страницу входа
            return redirect()->route('login');
        }
    }

    public function store(Request $request)
    {
        if (auth()->check()) {
            $user = auth()->id();
            $cartItems = CartItem::where('user_id', $user)->get();

            $address = DeliveryAddress::where('user_id', $user)
                ->where('status', 'selected')
                ->first();

            if (!$address) {
                return redirect()->back()->with([
                    'error' => 'Выберите адрес доставки'
                ]);
            }

            if ($cartItems->isEmpty()) {
                return redirect()->route('cart');
            }

            $total = $request->input('total-price') > 0 ? $request->input('total-price') : $cartItems->sum(function ($item) {
                return $item->quantity * $item->product->price;
            });

            if ($total > 100) {
                $userTotal = auth()->user();
                $userTotal->scores = (int)round($total / 100);
                $userTotal->save();
            }

            if ($request->input('total-minus-bonus') > 0) {
                // Add validation here to ensure positive value for 'total-minus-bonus'
                auth()->user()->decrement('scores', $request->input('total-minus-bonus'));
            }

            $dataOrder = [
                'user_id' => $user,
                'total' => $total,
                'delivery_address_id' => $address->id, // Use directly retrieved address ID
            ];

            $order = Order::create($dataOrder);

            foreach ($cartItems as $cartItem) {
                $orderItemData = [
                    'order_id' => $order->id,
                    'product_id' => $cartItem->product_id,
                    'quantity' => $cartItem->quantity,
                    'price' => $cartItem->product->price,
                ];
                OrderItem::create($orderItemData);
                $cartItem->delete();
            }

            return redirect()->route('profile')->with('message', 'Заказ успешно оформлен.');
        } else {
            return redirect()->route('login');
        }
    }


    public function show(Order $order)
    {
        // Проверяем, что пользователь авторизован и является владельцем этого заказа
        if (auth()->check() && $order->user_id == auth()->id()) {
            // Получаем товары в заказе
            $orderItems = $order->orderItems;

            // Возвращаем представление с информацией о заказе
            return view('orders.show', compact('order', 'orderItems'));
        } else {
            // Если пользователь не авторизован или не является владельцем заказа, перенаправляем на страницу входа
            return redirect()->route('login');
        }
    }
}
