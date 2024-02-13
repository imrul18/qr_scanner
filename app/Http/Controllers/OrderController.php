<?php

namespace App\Http\Controllers;

use App\Models\GlobalSetting;
use App\Models\ManualSetting;
use App\Models\Order;
use App\Models\RepurchaseHistory;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $breadcrumbs = [
            ['link' => "orders", 'name' => "Order"]
        ];
        $orders = Order::with('seller', 'customer');
        if ($request->has('q')) {
            $orders = $orders->whereHas('customer', function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->q . '%');
            });
        }
        if (Auth::user()->type != 1) {
            $orders = $orders->where('customer_id', Auth::user()->id);
        }
        $orders = $orders->paginate('10');
        return view('pages.orders.list', compact('orders', 'breadcrumbs'));
    }

    public function orderShow($id)
    {
        $breadcrumbs = [
            ['link' => "orders", 'name' => "Order"], ['name' => "Details"]
        ];
        $order = Order::with('seller', 'customer', 'repurchase_history.user')->find($id);
        if (Auth::user()->type != 1 && Auth::user()->id != $order->customer_id) {
            return redirect()->route('orders');
        }
        return view('pages.orders.view', compact('order', 'breadcrumbs'));
    }

    public function orderAdd(Request $request)
    {
        $breadcrumbs = [
            ['link' => "orders", 'name' => "Order"], ['name' => "Add"]
        ];
        $customers = User::where('type', 3)->get();
        $sellers = User::where('type', 2)->get();
        return view('pages.orders.add', compact('customers', 'sellers', 'breadcrumbs'));
    }

    public function orderAddButton(Request $request)
    {
        $request->validate(
            [
                'seller_id' => 'required',
                'customer_id' => 'required',
                'total_price' => 'required',
                'repurchase_price' => 'required|lt:total_price'
            ],
            [
                'seller_id.required' => 'Seller is required',
                'customer_id.required' => 'Customer is required',
                'total_price.required' => 'Total price is required',
                'repurchase_price.required' => 'Repurchase price is required',
                'repurchase_price.lt' => 'Repurchase price must be less than total price'
            ]
        );
        try {
            $exception = DB::transaction(function () use ($request) {
                $data = $request->only(['seller_id', 'customer_id', 'total_price', 'repurchase_price']);
                $order = Order::create($data);
                $this->repurchase_calculation($order);
            });

            if (is_null($exception)) {
                return redirect()->route('orders');
            } else {
                throw new Exception;
            }
        } catch (Exception $e) {
            return redirect()->route('orderAdd')
                ->with('error', 'Something wents wrong!')->withInput();
        }
    }

    public function repurchase_calculation($order)
    {
        $total = 0;
        $user = User::find($order->customer_id);
        $settings = ManualSetting::where('user_id', $user->id)->first();
        if (!$settings) {
            $settings = GlobalSetting::latest()->first();
        }
        foreach ($settings->percentage ?? [] as $index => $percentage) {
            $user = User::where('ref_code', $user->ref_by)->first();
            if ($user) {
                RepurchaseHistory::create([
                    'order_id' => $order->id,
                    'user_id' => $user->id,
                    'amount' => $order->repurchase_price * $percentage / 100,
                    'percentage' => $percentage,
                    'chain_serial' => $index + 1,
                    'is_heirarchy' => true,
                ]);
                $total += $percentage;

                $user->update([
                    'repurchase_amount' => $user->repurchase_amount + $order->repurchase_price * $percentage / 100,
                    'total_amount' => $user->total_amount + $order->repurchase_price * $percentage / 100,
                ]);
            } else {
                break;
            }
        }
        foreach ($settings->manual ?? [] as $index => $manual) {
            RepurchaseHistory::create([
                'order_id' => $order->id,
                'user_id' => $manual['user_id'],
                'amount' => $order->repurchase_price * $manual['percentage'] / 100,
                'percentage' => $manual['percentage'],
                'chain_serial' => count($settings->percentage) + $index + 1,
                'is_heirarchy' => false,
            ]);
            $total += $manual['percentage'];

            $user = User::find($manual['user_id']);
            $user->update([
                'repurchase_amount' => $user->repurchase_amount + $order->repurchase_price * $manual['percentage'] / 100,
                'total_amount' => $user->total_amount + $order->repurchase_price * $manual['percentage'] / 100,
            ]);
        }
        if ($total < 100) {
            RepurchaseHistory::create([
                'order_id' => $order->id,
                'user_id' => 1,
                'amount' => $order->repurchase_price * (100 - $total) / 100,
                'percentage' => 100 - $total,
                'chain_serial' => count($settings->percentage) + count($settings->manual) + 1,
                'is_heirarchy' => false,
                'remarks' => "Remaining amount"
            ]);
            $user = User::find(1);
            $user->update([
                'repurchase_amount' => $user->repurchase_amount + $order->repurchase_price * (100 - $total) / 100,
                'total_amount' => $user->total_amount + $order->repurchase_price * (100 - $total) / 100,
            ]);
        }
    }
}
