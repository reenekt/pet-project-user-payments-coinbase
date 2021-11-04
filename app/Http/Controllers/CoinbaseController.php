<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;

class CoinbaseController extends Controller
{
    /**
     * Endpoint for coinbase webhook
     *
     * @todo IMPLEMENT AND TEST (need to create payment with real crypto to find actual event json schema)
     * @see https://commerce.coinbase.com/docs/api/#webhooks Webhooks API docs
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function chargeWebhook(Request $request)
    {
        $event = $request->input('event');
        $eventType = $event['type'];

        // Payment done
        if ($eventType === 'charge:confirmed') {
            $payment = new Payment();
            $payment->user_from_id = json_decode($event['metadata']['custom'], true)['user_id'];
            $payment->status = 'done';
            $payment->amount = '0'; // SUM of $event->payments in one "selected" currency (see next line)
            $payment->currency = 'BTC'; // all should be converted to BTC (or another currency like USD, but BTC recommended)
            $payment->target_type = 'coinbase';
            $payment->target = [
                'wallet_address' => 'some_currency_wallet_address', // get it from $event
                'wallet_currency' => 'some_currency', // get it from $event
                'coinbase_charge_code' => 'some_charge_code', // get it from $event
                'coinbase_charge_uuid' => 'some_charge_uuid', // get it from $event
                'coinbase_checkout_uuid' => 'some_checkout_uuid', // get it from $event
            ];
            $payment->target_meta = []; // $event->metadata ?
            $payment->save();
            logger()->info('charge:confirmed processed, payment saved', [
                'event' => $event,
                'payment' => $payment,
            ]);
        }

        return response()->json('', 200);
    }
}
