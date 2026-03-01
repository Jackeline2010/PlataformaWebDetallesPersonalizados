<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PaymentMethodController extends Controller
{
   public function index() {
  return view('client.addresses'); // o client.payments / client.promos
}
}
