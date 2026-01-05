<?php

namespace App\Http\Controllers;

use App\Models\SubscriptionOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Midtrans\Config;
use Midtrans\Snap;

class SubscriptionController extends Controller
{
    private function midtransConfig(): void
    {
        Config::$serverKey    = config('midtrans.server_key');
        Config::$isProduction = false; // Sandbox mode
        Config::$isSanitized  = true;
        Config::$is3ds        = true;
    }

    public function plans()
    {
        $plans = [
            'starter'      => ['name' => 'Starter', 'price' => 49000],
            'starter_plus' => ['name' => 'Starter Plus', 'price' => 99000],
        ];

        return view('subscription.plans', compact('plans'));
    }

    public function subscribeFree(Request $request)
    {
        $user = Auth::user();
        $user->subscription_plan = 'free';
        $user->save();

        return redirect()->route('dashboard.user')->with('success', 'Kamu sekarang menggunakan paket Free.');
    }

    public function checkout($plan)
    {
        $user = Auth::user();

        $plans = [
            'starter'      => ['name' => 'Starter', 'price' => 9900],
            'starter_plus' => ['name' => 'Starter Plus', 'price' => 24900],
        ];

        abort_unless(isset($plans[$plan]), 404);

        $this->midtransConfig();

        $orderId = 'EATJOY-' . now()->format('YmdHis') . '-' . strtoupper(Str::random(6));
        $grossAmount = $plans[$plan]['price'];

        $order = SubscriptionOrder::create([
            'order_id' => $orderId,
            'user_id' => $user->id,
            'plan' => $plan,
            'gross_amount' => $grossAmount,
            'status' => 'created',
        ]);

        $params = [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => $grossAmount,
            ],
            'customer_details' => [
                'first_name' => $user->nickname ?? $user->username,
                'email' => $user->email,
            ],
            'item_details' => [
                [
                    'id' => $plan,
                    'price' => $grossAmount,
                    'quantity' => 1,
                    'name' => 'EatJoy ' . $plans[$plan]['name'],
                ]
            ],
        ];

        $snapToken = Snap::getSnapToken($params);

        $order->update([
            'snap_token' => $snapToken,
            'status' => 'pending',
        ]);

        return view('subscription.checkout', [
            'snapToken' => $snapToken,
            'plan' => $plan,
            'price' => $grossAmount,
        ]);
    }
}
