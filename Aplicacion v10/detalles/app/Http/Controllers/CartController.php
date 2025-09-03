<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    /**
     * Display the cart page
     */
    public function index()
    {
        $userId = Auth::id();
        $sessionId = Session::getId();
        
        // Get cart data with totals
        $cartData = Cart::calculateCartTotals($userId, $sessionId);
        
        return view('shop.checkout.cart', $cartData);
    }

    /**
     * Add product to cart
     */
    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'cantidad' => 'required|integer|min:1',
            'personalizacion' => 'nullable|array'
        ]);

        $product = Product::findOrFail($request->product_id);
        $userId = Auth::id();
        $sessionId = Session::getId();

        // Check if item already exists in cart
        $cartItem = Cart::where('product_id', $request->product_id)
            ->where(function ($query) use ($userId, $sessionId) {
                if ($userId) {
                    $query->where('user_id', $userId);
                } else {
                    $query->where('session_id', $sessionId);
                }
            })
            ->first();

        if ($cartItem) {
            // Update existing item
            $cartItem->cantidad += $request->cantidad;
            $cartItem->updateTotal();
        } else {
            // Create new cart item
            $cartItem = Cart::create([
                'user_id' => $userId,
                'session_id' => $userId ? null : $sessionId,
                'product_id' => $request->product_id,
                'cantidad' => $request->cantidad,
                'precio_unitario' => $product->precio,
                'descuento' => $product->descuento ?? 0,
                'personalizacion' => $request->personalizacion,
                'fecha_agregado' => now(),
            ]);
            $cartItem->updateTotal();
        }

        return response()->json([
            'success' => true,
            'message' => 'Producto agregado al carrito',
            'cart_count' => Cart::getCartItems($userId, $sessionId)->count()
        ]);
    }

    /**
     * Update cart item quantity
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'cantidad' => 'required|integer|min:1'
        ]);

        $userId = Auth::id();
        $sessionId = Session::getId();

        $cartItem = Cart::where('id', $id)
            ->where(function ($query) use ($userId, $sessionId) {
                if ($userId) {
                    $query->where('user_id', $userId);
                } else {
                    $query->where('session_id', $sessionId);
                }
            })
            ->firstOrFail();

        $cartItem->cantidad = $request->cantidad;
        $cartItem->updateTotal();

        return response()->json([
            'success' => true,
            'message' => 'Cantidad actualizada',
            'new_total' => $cartItem->total,
            'cart_totals' => Cart::calculateCartTotals($userId, $sessionId)
        ]);
    }

    /**
     * Remove item from cart
     */
    public function remove($id)
    {
        $userId = Auth::id();
        $sessionId = Session::getId();

        $cartItem = Cart::where('id', $id)
            ->where(function ($query) use ($userId, $sessionId) {
                if ($userId) {
                    $query->where('user_id', $userId);
                } else {
                    $query->where('session_id', $sessionId);
                }
            })
            ->firstOrFail();

        $cartItem->delete();

        return response()->json([
            'success' => true,
            'message' => 'Producto eliminado del carrito',
            'cart_totals' => Cart::calculateCartTotals($userId, $sessionId)
        ]);
    }

    /**
     * Clear entire cart
     */
    public function clear()
    {
        $userId = Auth::id();
        $sessionId = Session::getId();

        $query = Cart::query();
        
        if ($userId) {
            $query->where('user_id', $userId);
        } else {
            $query->where('session_id', $sessionId);
        }
        
        $query->delete();

        return response()->json([
            'success' => true,
            'message' => 'Carrito vaciado'
        ]);
    }

    /**
     * Get cart count for AJAX requests
     */
    public function count()
    {
        $userId = Auth::id();
        $sessionId = Session::getId();
        
        $count = Cart::getCartItems($userId, $sessionId)->count();
        
        return response()->json(['count' => $count]);
    }
}
