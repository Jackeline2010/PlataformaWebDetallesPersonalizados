<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Extra;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CartController extends Controller
{
    private const DEDICATION_MAX_WORDS = 20;

    public function index()
{
    $cart = session()->get('cart', []);

    $subtotal = collect($cart)->sum(function ($item) {
        return (float) ($item['total'] ?? 0);
    });

    $productsCount = collect($cart)->sum(function ($item) {
        return (int) ($item['quantity'] ?? 1);
    });

    $shipping = 0;
    $discount = 0;

    $total = $subtotal + $shipping - $discount;

    return view('client.cart.index', compact(
        'cart',
        'subtotal',
        'productsCount',
        'shipping',
        'discount',
        'total'
    ));
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

    $productsCount = collect($cart)->sum(function ($item) {
        return (int) ($item['quantity'] ?? 1);
    });

    $shipping = 0;
    $discount = 0;

    $total = $subtotal + $shipping - $discount;

    return view('client.checkout.index', compact(
        'cart',
        'subtotal',
        'productsCount',
        'shipping',
        'discount',
        'total'
    ));
    }

    public function buyAsIs(Request $request, Product $product)
    {
        if (!$product->activo) {
            return back()->with('error', 'Este producto no está disponible.');
        }

        $cart = session()->get('cart', []);

        $productId = (string) $product->id;
        $basePrice = (float) $product->precio;

        if (isset($cart[$productId]) && empty($cart[$productId]['is_customized'])) {
            $cart[$productId]['quantity'] += 1;
            $cart[$productId]['total'] =
                (float) $cart[$productId]['unit_price'] *
                (int) $cart[$productId]['quantity'];
        } else {
            $cart[$productId] = [
                'id' => $productId,
                'product_id' => $product->id,
                'name' => $product->nombre,
                'slug' => $product->slug,
                'image' => $product->imagen_principal,
                'preview_image' => null,
                'quantity' => 1,
                'base_price' => $basePrice,
                'photo_price' => 0,
                'extras_total' => 0,
                'custom_price' => 0,
                'unit_price' => $basePrice,
                'total' => $basePrice,
                'is_customized' => false,
                'dedicatoria' => null,
                'destinatario' => null,
                'color' => null,
                'selected_color' => null,
                'photo' => null,
                'extras' => [],
                'custom_fields' => [],
                'design_json' => null,
                'frase' => null,
            ];
        }

        session()->put('cart', $cart);

        return redirect()
            ->route('client.cart.index')
            ->with('success', 'Producto agregado al carrito correctamente.');
    }

    public function add(Request $request, Product $product)
    {
        if (!$product->activo) {
            return back()->with('error', 'Este producto no está disponible.');
        }

        $validated = $request->validate([
            'quantity' => ['nullable', 'integer', 'min:1'],

            'dedicatoria' => [
                'nullable',
                'string',
                function ($attribute, $value, $fail) {
                    $wordCount = $this->countWords($value);

                    if ($wordCount > self::DEDICATION_MAX_WORDS) {
                        $fail('La dedicatoria no puede tener más de ' . self::DEDICATION_MAX_WORDS . ' palabras.');
                    }
                },
            ],

            'destinatario' => ['nullable', 'string', 'max:100'],
            'frase' => ['nullable', 'string', 'max:255'],
            'selected_color' => ['nullable', 'string', 'max:100'],
            'color' => ['nullable', 'string', 'max:100'],

            'preview_image' => ['nullable', 'string'],
            'design_json' => ['nullable', 'string'],

            'customer_photo' => ['nullable', 'file', 'max:10240'],

            'extras' => ['nullable', 'array'],
            'extras.*' => ['integer', 'exists:extras,id'],

            'custom_fields' => ['nullable', 'array'],
        ]);

        $quantity = max(1, (int) ($validated['quantity'] ?? 1));
        $basePrice = (float) $product->precio;

        $cleanDedicatoria = $this->normalizeSpaces($validated['dedicatoria'] ?? null);
        $cleanDestinatario = $this->normalizeSpaces($validated['destinatario'] ?? null);
        $cleanFrase = $this->normalizeSpaces($validated['frase'] ?? null);

        $selectedColor = $validated['selected_color'] ?? null;
        $color = $validated['color'] ?? $selectedColor;

        $photoPrice = 0;
        $photoPath = null;

        if ($request->hasFile('customer_photo')) {
            $photoPath = $request->file('customer_photo')->store('customizations/photos', 'public');
            $photoPrice = (float) ($product->photo_print_price ?? 0);
        }

        $selectedExtras = collect();
        $extrasTotal = 0;

        if (!empty($validated['extras'])) {
            $selectedExtras = Extra::whereIn('id', $validated['extras'])
                ->where('activo', true)
                ->get();

            $extrasTotal = (float) $selectedExtras->sum('precio_adicional');
        }

        $customPrice = 0;
        $unitPrice = $basePrice + $photoPrice + $extrasTotal + $customPrice;
        $total = $unitPrice * $quantity;

        $cart = session()->get('cart', []);
        $cartItemId = (string) Str::uuid();

        $cart[$cartItemId] = [
            'id' => $cartItemId,
            'product_id' => $product->id,
            'name' => $product->nombre,
            'slug' => $product->slug,
            'image' => $product->imagen_principal,
            'preview_image' => $validated['preview_image'] ?? null,
            'quantity' => $quantity,
            'base_price' => $basePrice,
            'photo_price' => $photoPrice,
            'extras_total' => $extrasTotal,
            'custom_price' => $customPrice,
            'unit_price' => $unitPrice,
            'total' => $total,
            'is_customized' => true,
            'dedicatoria' => $cleanDedicatoria,
            'destinatario' => $cleanDestinatario,
            'frase' => $cleanFrase,
            'color' => $color,
            'selected_color' => $selectedColor,
            'photo' => $photoPath,
            'custom_fields' => $validated['custom_fields'] ?? [],
            'design_json' => $validated['design_json'] ?? null,

            'extras' => $selectedExtras->map(function ($extra) {
                return [
                    'id' => $extra->id,
                    'nombre' => $extra->nombre,
                    'precio' => (float) $extra->precio_adicional,
                    'imagen' => $extra->imagen ?? null,
                ];
            })->values()->toArray(),
        ];

        session()->put('cart', $cart);

        return redirect()
            ->route('client.cart.index')
            ->with('success', 'Producto personalizado agregado al carrito correctamente.');
    }

    public function remove(string $itemId)
{
    $cart = session()->get('cart', []);

    if (isset($cart[$itemId])) {
        unset($cart[$itemId]);
        session()->put('cart', $cart);
    }

    return redirect()
        ->route('client.cart.index')
        ->with('success', 'Producto eliminado del carrito.');
    }


    public function updateQuantity(Request $request, string $itemId)
{
    $cart = session()->get('cart', []);

    if (!isset($cart[$itemId])) {
        return back();
    }

    $quantity = max(1, (int) $request->quantity);

    $cart[$itemId]['quantity'] = $quantity;

    $cart[$itemId]['total'] =
        (float) $cart[$itemId]['unit_price'] * $quantity;

    session()->put('cart', $cart);

    return back()->with('success', 'Cantidad actualizada.');
}

    private function countWords(?string $text): int
    {
        $text = $this->normalizeSpaces($text);

        if (empty($text)) {
            return 0;
        }

        return count(preg_split('/\s+/', $text, -1, PREG_SPLIT_NO_EMPTY));
    }

    private function normalizeSpaces(?string $text): ?string
    {
        if ($text === null) {
            return null;
        }

        $text = trim($text);

        if ($text === '') {
            return null;
        }

        return preg_replace('/\s+/', ' ', $text);
    }
}
