<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\DeliveryAddress;
use Illuminate\Http\Request;

class CartItemController extends Controller
{
    public function index()
    {
        if (auth()->check()) {
            $userId = auth()->id();
            $cartItems = CartItem::with('product')->where('user_id', $userId)->get();
            $addresses = DeliveryAddress::where('user_id', $userId)->get();
            return view('cart', compact('cartItems', 'addresses'));
        } else {
            return redirect()->route('login');
        }
    }

    public function addToCart(Request $request)
    {
        if (auth()->check()) {
            $userId = auth()->id();
            $productId = $request->input('product_id');
            $quantity = 1;

            $cartItem = CartItem::where('user_id', $userId)
                ->where('product_id', $productId)
                ->first();

            if ($cartItem) {
                $cartItem->quantity += $quantity;
                $cartItem->save();
            } else {
                $data = [
                    'user_id' => $userId,
                    'product_id' => $productId,
                    'quantity' => $quantity];
                CartItem::create($data);
            }
            return redirect()->route('cart');
        } else {
            return redirect()->route('login');
        }
    }

    public function update(Request $request, CartItem $cartItem)
    {
        if (auth()->check() && $cartItem->user_id == auth()->id()) {
            if ($request->action == 'increment') {
                $cartItem->quantity++;
            } elseif ($request->action == 'decrement' && $cartItem->quantity > 1) {
                $cartItem->quantity--;
            } else {
                $cartItem->delete();
                return redirect()->route('cart');
            }

            $cartItem->save();
        }

        return redirect()->route('cart');
    }
    public function updatePaymentMethod(Request $request)
    {
        // Получаем текущего пользователя
        $user = auth()->user();

        // Проверяем, был ли передан метод оплаты
        if ($request->has('method')) {
            $user->payment = $request->method;
            $user->save();

            // Возвращаем успешный ответ в JSON формате
            return response()->json(['success' => true, 'message' => 'Способ оплаты успешно обновлен']);
        } else {
            // Возвращаем ошибку в JSON формате, если метод оплаты не был передан
            return response()->json(['success' => false, 'message' => 'Метод оплаты не указан'], 400);
        }
    }
    public function destroy(CartItem $cartItem)
    {
        if (auth()->check() && $cartItem->user_id == auth()->id()) {
            $cartItem->delete();
        }

        return redirect()->route('cart');
    }
}

