<?php

namespace App\Http\Controllers\Payments;

use App\Http\Controllers\Controller;
use App\Models\Products;
use App\Models\Transactions;
use Illuminate\Http\Request;

class PaymentsController extends Controller
{
    public function index()
    {
        $products   = Products::latest()->get();

        return view('pages.payment.index', compact('products'));
    }

    public function getSnapToken(Request $request)
    {
        try {
            $request->validate([
                'product_id'  => 'required|exists:products,id',
                'category_id' => 'required|exists:categories,id',
                'qty'         => 'required|integer|min:1',
                'total_price' => 'required|numeric|min:1',
                'unit_price'  => 'required|numeric|min:1',
            ]);

            $serverKey  = config('services.midtrans.server_key');
            $orderId    = 'TRX-' . time() . '-' . auth()->id();
            $unitPrice  = (int) $request->unit_price;
            $qty        = (int) $request->qty;
            $totalPrice = (int) $request->total_price;
            $product    = Products::findOrFail($request->product_id);

            $payload = [
                'transaction_details' => [
                    'order_id'     => $orderId,
                    'gross_amount' => $totalPrice,
                ],
                'customer_details' => [
                    'first_name' => auth()->user()->name,
                    'email'      => auth()->user()->email,
                ],
                'item_details' => [
                    [
                        'id'       => (string) $request->product_id,
                        'price'    => $unitPrice,
                        'quantity' => $qty,
                        'name'     => $product->name,
                    ]
                ],
            ];

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'https://app.sandbox.midtrans.com/snap/v1/transactions');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Content-Type: application/json',
                'Accept: application/json',
                'Authorization: Basic ' . base64_encode($serverKey . ':'),
            ]);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            $result = json_decode($response, true);

            if ($httpCode !== 201 || empty($result['token'])) {
                return response()->json([
                    'error'   => true,
                    'message' => 'Payment failed. Please try again.',
                ], 500);
            }

            $transaction = Transactions::create([
                'category_id' => $request->category_id,
                'product_id'  => $request->product_id,
                'qty'         => $qty,
                'unit_price'  => $unitPrice,
                'total_price' => $totalPrice,
                'snap_token'  => $result['token'],
                'status'      => 'pending',
                'note'        => $request->note,
            ]);

            return response()->json([
                'snap_token'     => $result['token'],
                'transaction_id' => $transaction->id,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'error'   => true,
                'message' => $e->getMessage(),
            ], 500);
        }
    }


    public function updateStatus(Request $request)
{
    try {
        $request->validate([
            'transaction_id' => 'required|exists:transactions,id',
            'status'         => 'required|in:success,failed,pending',
        ]);

        $transaction = Transactions::findOrFail($request->transaction_id);

        $transaction->update(['status' => $request->status]);

        if ($request->status === 'success') {
            $product = Products::findOrFail($transaction->product_id);
            $product->qty = max(0, $product->qty - $transaction->qty); // ← prevent negative stock
            $product->save();
        }

        return response()->json(['message' => 'Status updated']);

    } catch (\Exception $e) {
        return response()->json([
            'error'   => true,
            'message' => $e->getMessage(),
        ], 500);
    }
}
}