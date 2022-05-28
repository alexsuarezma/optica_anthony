<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Order;

class OrderController extends Controller
{
    public function index(){
        $orders = Order::orderBy('created_at','desc')->paginate(10);
        return view('order.index', [
            'orders' => $orders,
        ]);
    }
}
