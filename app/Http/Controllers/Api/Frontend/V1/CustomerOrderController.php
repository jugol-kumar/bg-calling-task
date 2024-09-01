<?php

namespace App\Http\Controllers\Api\Frontend\V1;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerOrderController extends Controller
{
    public function customerOrders()
    {
        $orders = Order::query()
            ->with(['customer', 'address'])
            ->withCount('orderDetails')
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        return response()->json($orders);
    }
    public function showCustomerOrder($id)
    {
        $order = Order::query()
            ->with(['customer', 'address.orderArea', 'orderDetails.product'])
            ->findOrFail($id);


        return response()->json($order);
    }
}
