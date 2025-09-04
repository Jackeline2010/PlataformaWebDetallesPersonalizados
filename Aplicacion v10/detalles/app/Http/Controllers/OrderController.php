<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Display the order summary page
     */
    public function index(Request $request)
    {
        $userId = Auth::id();
        $sessionId = Session::getId();
        
        // Get order ID from request or session
        $orderId = $request->get('order_id') ?? Session::get('current_order_id');
        
        if ($orderId) {
            // Get existing order
            $order = Order::with(['orderProducts.product'])->find($orderId);
            
            if (!$order) {
                return redirect()->route('cart')->with('error', 'Orden no encontrada');
            }
            
            $orderItems = $order->orderProducts;
            $subtotal = $order->subtotal;
            $descuento = $order->descuento;
            $impuesto = $order->impuesto;
            $total = $order->total;
            
        } else {
            // Create order from cart items
            $cartItems = Cart::getCartItems($userId, $sessionId);
            
            if ($cartItems->isEmpty()) {
                return redirect()->route('cart')->with('error', 'El carrito está vacío');
            }
            
            // Calculate totals from cart
            $cartTotals = Cart::calculateCartTotals($userId, $sessionId);
            $subtotal = $cartTotals['subtotal'];
            $descuento = $cartTotals['discount'];
            $impuesto = $cartTotals['tax'];
            $total = $cartTotals['total'];
            
            // Create new order
            $order = $this->createOrderFromCart($cartItems, $subtotal, $descuento, $impuesto, $total, $userId);
            $orderItems = $order->orderProducts;
            
            // Store order ID in session
            Session::put('current_order_id', $order->id);
        }
        
        return view('shop.checkout.order', compact('order', 'orderItems', 'subtotal', 'descuento', 'impuesto', 'total'));
    }
    
    /**
     * Create order from cart items
     */
    private function createOrderFromCart($cartItems, $subtotal, $descuento, $impuesto, $total, $userId)
    {
        return DB::transaction(function () use ($cartItems, $subtotal, $descuento, $impuesto, $total, $userId) {
            // Get or create a default client with error handling
            $defaultClient = \App\Models\Client::where('email', 'guest@sandydecor.com')->first();
            
            if (!$defaultClient) {
                try {
                    $defaultClient = \App\Models\Client::create([
                        'identificacion' => 'GUEST001',
                        'nombres' => 'Cliente',
                        'apellidos' => 'Invitado',
                        'email' => 'guest@sandydecor.com',
                        'telefono' => '000-000-0000',
                        'fingreso' => now()->toDateString(),
                        'activo' => true,
                    ]);
                } catch (\Exception $e) {
                    // If creation fails (e.g., duplicate key), try to find the client again
                    $defaultClient = \App\Models\Client::where('email', 'guest@sandydecor.com')->first();
                    
                    // If still not found, throw the original exception
                    if (!$defaultClient) {
                        throw $e;
                    }
                }
            }

            // Create order
            $order = Order::create([
                'user_id' => $userId,
                'client_id' => $defaultClient->id,
                'forma_pago_id' => 1, // Default payment method
                'numero_orden' => $this->generateOrderNumber(),
                'fpedido' => now()->toDateString(),
                'estado' => 'ING',
                'subtotal' => $subtotal,
                'impuesto' => $impuesto,
                'descuento' => $descuento,
                'total' => $total,
            ]);
            
            // Create order products from cart items
            foreach ($cartItems as $cartItem) {
                OrderProduct::create([
                    'order_id' => $order->id,
                    'product_id' => $cartItem->product_id,
                    'cantidad' => $cartItem->cantidad,
                    'precio_unitario' => $cartItem->precio_unitario,
                    'descuento' => $cartItem->descuento,
                    'total' => $cartItem->total,
                ]);
            }
            
            // Load the order products relationship
            $order->load('orderProducts.product');
            
            return $order;
        });
    }
    
    /**
     * Generate unique order number
     */
    private function generateOrderNumber()
    {
        $prefix = 'ORD';
        $date = now()->format('Ymd');
        $sequence = Order::whereDate('created_at', now()->toDateString())->count() + 1;
        
        return $prefix . $date . str_pad($sequence, 4, '0', STR_PAD_LEFT);
    }
    
    /**
     * Confirm the order
     */
    public function confirm(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'terms_accepted' => 'required|accepted',
        ]);
        
        $order = Order::findOrFail($request->order_id);
        
        // Update order status
        $order->update([
            'estado' => 'PEN', // Pendiente
            'fentrega' => now()->addDays(3)->toDateString(), // Default delivery in 3 days
        ]);
        
        // Clear cart after order confirmation
        $userId = Auth::id();
        $sessionId = Session::getId();
        
        if ($userId) {
            Cart::where('user_id', $userId)->delete();
        } else {
            Cart::where('session_id', $sessionId)->delete();
        }
        
        // Clear order session
        Session::forget('current_order_id');
        
        return response()->json([
            'success' => true,
            'message' => 'Orden confirmada exitosamente',
            'order_number' => $order->numero_orden,
        ]);
    }
    
    /**
     * Update billing information
     */
    public function updateBilling(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'direccion_entrega' => 'required|string|max:255',
            'contacto_entrega' => 'required|string|max:255',
            'telefono_contacto' => 'required|string|max:20',
            'observaciones' => 'nullable|string',
        ]);
        
        $order = Order::findOrFail($request->order_id);
        
        $order->update([
            'direccion_entrega' => $request->direccion_entrega,
            'contacto_entrega' => $request->contacto_entrega,
            'telefono_contacto' => $request->telefono_contacto,
            'observaciones' => $request->observaciones,
        ]);
        
        return response()->json([
            'success' => true,
            'message' => 'Información de entrega actualizada',
        ]);
    }
}
