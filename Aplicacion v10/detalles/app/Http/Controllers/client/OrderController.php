<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with(['orderProducts.product', 'orderProducts.customizations'])
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('client.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        abort_unless($order->user_id === Auth::id(), 403);

        $order->load(['orderProducts.product', 'orderProducts.customizations.field', 'orderProducts.customizations.option']);

        return view('client.orders.show', compact('order'));
    }

    public function checkout()
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()
                ->route('client.cart.index')
                ->with('error', 'Tu carrito está vacío.');
        }

        $subtotal = collect($cart)->sum(function ($item) {
            return (float) ($item['total'] ?? 0);
        });

        return view('client.checkout.index', compact('cart', 'subtotal'));
    }

    public function store(Request $request)
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()
                ->route('client.cart.index')
                ->with('error', 'Tu carrito está vacío.');
        }

        $subtotal = collect($cart)->sum(function ($item) {
            return (float) ($item['total'] ?? 0);
        });

        DB::transaction(function () use ($cart, $subtotal, &$order) {
            $user = Auth::user();

            $client = $user->client;

if (!$client) {
    $client = Client::create([
    'user_id' => $user->id,
    'identificacion' => 'TEMP-' . $user->id,
    'nombres' => $user->name ?? 'Cliente',
    'apellidos' => '',
    'email' => $user->email,
    'telefono' => $user->telefono ?? null,
    'fnacimiento' => null,
    'genero' => null,
    'fingreso' => now()->toDateString(),
    'activo' => true,
]);
}

$clientId = $client->id;

            $extrasResumen = [];

            $order = Order::create([
                'client_id' => $clientId,
                'user_id' => $user->id,
                'forma_pago_id' => null,
                'numero_orden' => 'ORD-' . now()->format('YmdHis'),
                'fpedido' => now()->toDateString(),
                'fentrega' => null,
                'estado' => 'PEN',
                'subtotal' => $subtotal,
                'impuesto' => 0,
                'descuento' => 0,
                'total' => $subtotal,
                'direccion_entrega' => null,
                'contacto_entrega' => null,
                'telefono_contacto' => null,
                'observaciones' => null,
            ]);

            foreach ($cart as $item) {
                $product = Product::with(['customFields.options'])->find($item['product_id'] ?? null);

                $orderProduct = $order->orderProducts()->create([
                    'product_id' => $item['product_id'] ?? null,
                    'cantidad' => (int) ($item['quantity'] ?? 1),
                    'precio_unitario' => (float) ($item['unit_price'] ?? 0),
                    'descuento' => 0,
                    'total' => (float) ($item['total'] ?? 0),
                ]);

                if (!$product) {
                    continue;
                }

                $customFields = $product->customFields ?? collect();

                $dedicatoriaField = $customFields->first(function ($field) {
                    return str_contains(mb_strtolower($field->label ?? ''), 'dedicatoria');
                });

                $destinatarioField = $customFields->first(function ($field) {
                    return str_contains(mb_strtolower($field->label ?? ''), 'destinatario');
                });

                $fraseField = $customFields->first(function ($field) {
                    return str_contains(mb_strtolower($field->label ?? ''), 'frase');
                });

                $fotoField = $customFields->first(function ($field) {
                    $label = mb_strtolower($field->label ?? '');
                    return str_contains($label, 'foto') || ($field->type ?? '') === 'image';
                });

                $colorField = $customFields->first(function ($field) {
                    return str_contains(mb_strtolower($field->label ?? ''), 'color');
                });

                if (!empty($item['dedicatoria']) && $dedicatoriaField) {
                    $orderProduct->customizations()->create([
                        'field_id' => $dedicatoriaField->id,
                        'option_id' => null,
                        'value_text' => $item['dedicatoria'],
                        'extra_price' => 0,
                    ]);
                }

                if (!empty($item['destinatario']) && $destinatarioField) {
                    $orderProduct->customizations()->create([
                        'field_id' => $destinatarioField->id,
                        'option_id' => null,
                        'value_text' => $item['destinatario'],
                        'extra_price' => 0,
                    ]);
                }

                if (!empty($item['frase']) && $fraseField) {
                    $orderProduct->customizations()->create([
                        'field_id' => $fraseField->id,
                        'option_id' => null,
                        'value_text' => $item['frase'],
                        'extra_price' => 0,
                    ]);
                }

                if (!empty($item['photo']) && $fotoField) {
                    $orderProduct->customizations()->create([
                        'field_id' => $fotoField->id,
                        'option_id' => null,
                        'value_text' => $item['photo'],
                        'extra_price' => (float) ($item['photo_price'] ?? 0),
                    ]);
                }

                $selectedColor = $item['color'] ?? ($item['selected_color'] ?? null);

                if (!empty($selectedColor) && $colorField) {
                    $matchedOption = collect($colorField->options ?? [])->first(function ($option) use ($selectedColor) {
                        return mb_strtolower($option->label ?? '') === mb_strtolower($selectedColor);
                    });

                    $orderProduct->customizations()->create([
                        'field_id' => $colorField->id,
                        'option_id' => $matchedOption->id ?? null,
                        'value_text' => $matchedOption ? null : $selectedColor,
                        'extra_price' => (float) ($matchedOption->extra_price ?? 0),
                    ]);
                }

                if (!empty($item['extras']) && is_array($item['extras'])) {
                    $extrasResumen[] = [
                        'producto' => $item['name'] ?? 'Producto',
                        'extras' => $item['extras'],
                    ];
                }
            }

            if (!empty($extrasResumen)) {
                $order->observaciones = "Extras del pedido:\n" . json_encode($extrasResumen, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
                $order->save();
            }
        });

        session()->forget('cart');

        return redirect()
            ->route('client.orders.show', $order)
            ->with('success', 'Tu pedido fue registrado correctamente.');
    }
}
