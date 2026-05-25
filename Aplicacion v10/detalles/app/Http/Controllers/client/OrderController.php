<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    private const COSTO_ENTREGA_DOMICILIO = 2.00;

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
        if ((int) $order->user_id !== (int) Auth::id()) {
            abort(403);
        }

        $order->load([
            'orderProducts.product',
            'orderProducts.customizations',
        ]);

        $orderItems = $order->orderProducts;

        $subtotal = (float) ($order->subtotal ?? 0);
        $descuento = (float) ($order->descuento ?? 0);
        $impuesto = (float) ($order->impuesto ?? 0);
        $costoEntrega = (float) ($order->costo_entrega ?? 0);
        $total = (float) ($order->total ?? 0);

        return view('client.orders.show', compact(
            'order',
            'orderItems',
            'subtotal',
            'descuento',
            'impuesto',
            'costoEntrega',
            'total'
        ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tipo_entrega' => ['required', 'string'],
            'zona_entrega' => ['nullable', 'string'],

            'direccion_entrega' => [
                'nullable',
                'string',
                'max:255',
                'required_if:tipo_entrega,domicilio',
            ],

            'telefono_contacto' => ['required', 'string', 'max:20'],
            'contacto_entrega' => ['nullable', 'string', 'max:100'],
            'observaciones' => ['nullable', 'string', 'max:500'],
        ]);

        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()
                ->route('client.cart.index')
                ->with('error', 'Tu carrito está vacío.');
        }

        $subtotal = collect($cart)->sum(function ($item) {
            return (float) ($item['total'] ?? 0);
        });

        if ($validated['tipo_entrega'] === 'retiro_tienda') {

        $costoEntrega = 0.00;

        } else {

        $zonaEntrega = $request->zona_entrega ?? 'centro';
        $costoEntrega = match ($zonaEntrega) {

        'centro' => 3.00,
        'urbana' => 4.00,
        'lejana' => 5.00,

        default => 2.00,
    };
}

        $impuesto = 0;
        $descuento = 0;
        $total = $subtotal + $costoEntrega + $impuesto - $descuento;

        $order = null;

        DB::transaction(function () use ($cart, $subtotal, $costoEntrega, $impuesto, $descuento, $total, $validated, &$order) {
            $user = Auth::user();

            $client = $user->client;

            if (!$client) {
                $client = Client::create([
                    'user_id' => $user->id,
                    'identificacion' => 'TEMP-' . $user->id,
                    'nombres' => $user->name ?? 'Cliente',
                    'apellidos' => '',
                    'email' => $user->email,
                    'telefono' => $validated['telefono_contacto'] ?? ($user->telefono ?? null),
                    'fnacimiento' => null,
                    'genero' => null,
                    'fingreso' => now()->toDateString(),
                    'activo' => true,
                ]);
            }

            $order = Order::create([
                'client_id' => $client->id,
                'user_id' => $user->id,
                'forma_pago_id' => 1,
                'numero_orden' => 'ORD-' . now()->format('YmdHis'),
                'fpedido' => now()->toDateString(),
                'fentrega' => null,
                'estado' => 'PEN',
                'tipo_entrega' => $validated['tipo_entrega'],
                'costo_entrega' => $costoEntrega,
                'subtotal' => $subtotal,
                'impuesto' => $impuesto,
                'descuento' => $descuento,
                'total' => $total,
                'direccion_entrega' => $validated['tipo_entrega'] === 'retiro_tienda'
                    ? 'RETIRO EN TIENDA FÍSICA'
                    : ($validated['direccion_entrega'] ?? null),
                'contacto_entrega' => $validated['contacto_entrega'] ?? ($user->name ?? 'Cliente'),
                'telefono_contacto' => $validated['telefono_contacto'],
                'observaciones' => $validated['observaciones'] ?? null,
            ]);

            foreach ($cart as $item) {
                $product = Product::with(['customFields.options'])
                    ->find($item['product_id'] ?? null);

                $orderProduct = $order->orderProducts()->create([
                    'product_id' => $item['product_id'] ?? null,
                    'cantidad' => (int) ($item['quantity'] ?? 1),
                    'precio_unitario' => (float) ($item['unit_price'] ?? 0),
                    'descuento' => 0,
                    'total' => (float) ($item['total'] ?? 0),
                    'preview_image' => $item['preview_image'] ?? null,
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
            }
        });

        session()->forget('cart');

        return redirect()
            ->route('client.orders.show', $order)
            ->with('success', 'Tu pedido fue registrado correctamente.');
    }
}
