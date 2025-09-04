<?php

namespace App\Http\Controllers;

use App\Mail\ContactMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class ContactController extends Controller
{
    /**
     * Display the contact form
     */
    public function index()
    {
        return view('shop.pages.contact');
    }

    /**
     * Handle the contact form submission
     */
    public function send(Request $request)
    {
        // Validate the form data
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'telefono' => 'nullable|string|max:20',
            'asunto' => 'required|string|in:consulta,pedido,soporte,otro',
            'mensaje' => 'required|string|max:2000',
        ], [
            'nombre.required' => 'Por favor ingresa tu nombre.',
            'nombre.max' => 'El nombre no puede exceder 255 caracteres.',
            'email.required' => 'Por favor ingresa tu correo electrónico.',
            'email.email' => 'Ingresa un correo electrónico válido.',
            'email.max' => 'El correo no puede exceder 255 caracteres.',
            'telefono.max' => 'El teléfono no puede exceder 20 caracteres.',
            'asunto.required' => 'Selecciona un asunto.',
            'asunto.in' => 'Selecciona un asunto válido.',
            'mensaje.required' => 'Por favor ingresa un mensaje.',
            'mensaje.max' => 'El mensaje no puede exceder 2000 caracteres.',
        ]);

        try {
            // Send the email
            Mail::to('soporte@sandydecor.com')->send(new ContactMail($validated));

            // Log the contact form submission
            Log::info('Contact form submitted', [
                'nombre' => $validated['nombre'],
                'email' => $validated['email'],
                'asunto' => $validated['asunto'],
                'timestamp' => now()
            ]);

            return response()->json([
                'success' => true,
                'message' => '¡Gracias! Tu mensaje ha sido enviado con éxito. Te responderemos lo antes posible.'
            ]);

        } catch (\Exception $e) {
            // Log the error
            Log::error('Contact form submission failed', [
                'error' => $e->getMessage(),
                'email' => $validated['email'],
                'timestamp' => now()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Hubo un error al enviar tu mensaje. Por favor intenta nuevamente o contáctanos directamente.'
            ], 500);
        }
    }
}
