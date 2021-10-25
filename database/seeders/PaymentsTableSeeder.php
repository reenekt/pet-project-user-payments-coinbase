<?php

namespace Database\Seeders;

use App\Models\Payment;
use App\Models\User;
use Cknow\Money\Money;
use Illuminate\Database\Seeder;

class PaymentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $allUsers = User::all();
        $firstUser = User::query()->first();
        $someUsers = $allUsers->shuffle()->take(rand(1, $allUsers->count()))->merge([$firstUser]);

        foreach ($someUsers as $someUser) {
            $dummyPayment = new Payment();
            $dummyPayment->comment = 'another one dummy payment';
            $dummyPayment->user_from_id = $someUser->getKey();
            $dummyPayment->status = 'done';
            $dummyPayment->amount = number_format((float)rand(1, 150), 2, '.', '');
            $dummyPayment->currency = 'USD';
            $dummyPayment->target_type = 'dummy';
            $dummyPayment->target = [];
            $dummyPayment->target_meta = [];
            $dummyPayment->save();

            if (rand(0, 1)) {
                $dummyFailedPayment = new Payment();
                $dummyFailedPayment->comment = 'another one dummy payment (failed)';
                $dummyFailedPayment->user_from_id = $someUser->getKey();
                $dummyFailedPayment->status = 'failed';
                $dummyFailedPayment->amount = number_format((float)rand(1, 150), 2, '.', '');
                $dummyFailedPayment->currency = 'USD';
                $dummyFailedPayment->target_type = 'dummy';
                $dummyFailedPayment->target = [];
                $dummyFailedPayment->target_meta = [];
                $dummyFailedPayment->save();
            }

            if (rand(0, 1)) {
                $dummyCancelledPayment = new Payment();
                $dummyCancelledPayment->comment = 'another one dummy payment (cancelled)';
                $dummyCancelledPayment->user_from_id = $someUser->getKey();
                $dummyCancelledPayment->status = 'cancelled';
                $dummyCancelledPayment->amount = number_format((float)rand(1, 150), 2, '.', '');
                $dummyCancelledPayment->currency = 'USD';
                $dummyCancelledPayment->target_type = 'dummy';
                $dummyCancelledPayment->target = [];
                $dummyCancelledPayment->target_meta = [];
                $dummyCancelledPayment->save();
            }
        }

        $someUsers = $allUsers->shuffle()->take(rand(1, $allUsers->count()))->merge([$firstUser]);
        foreach ($someUsers as $someUser) {
            $coinbaseDummyBTCPayment = new Payment();
            $coinbaseDummyBTCPayment->comment = 'another one dummy BTC payment';
            $coinbaseDummyBTCPayment->user_from_id = $someUser->getKey();
            $coinbaseDummyBTCPayment->status = 'done';
            $coinbaseDummyBTCPayment->amount = Money::parseByDecimal((string)rand(1, 20), 'BTC')->formatByDecimal();
            $coinbaseDummyBTCPayment->currency = 'BTC';
            $coinbaseDummyBTCPayment->target_type = 'coinbase';
            $coinbaseDummyBTCPayment->target = [
                'wallet_address' => 'dummy_bitcoin_wallet_address',
                'coinbase_charge_code' => 'some_charge_code', // optional
                'coinbase_charge_uuid' => 'some_charge_uuid', // optional
                'coinbase_checkout_uuid' => 'some_checkout_uuid', // optional
            ];
            $coinbaseDummyBTCPayment->target_meta = [
                'isDummy' => 'yes',
            ];
            $coinbaseDummyBTCPayment->save();

            $coinbaseDummyDOGEPayment = new Payment();
            $coinbaseDummyDOGEPayment->comment = 'another one dummy DOGE payment';
            $coinbaseDummyDOGEPayment->user_from_id = $someUser->getKey();
            $coinbaseDummyDOGEPayment->status = 'done';
            $coinbaseDummyDOGEPayment->amount = Money::parseByDecimal((string)rand(1000, 30000), 'DOGE')->formatByDecimal();
            $coinbaseDummyDOGEPayment->currency = 'DOGE';
            $coinbaseDummyDOGEPayment->target_type = 'coinbase';
            $coinbaseDummyDOGEPayment->target = [
                'wallet_address' => 'dummy_dogecoin_wallet_address',
                'coinbase_charge_code' => 'some_charge_code', // optional
                'coinbase_charge_uuid' => 'some_charge_uuid', // optional
                'coinbase_checkout_uuid' => 'some_checkout_uuid', // optional
            ];
            $coinbaseDummyDOGEPayment->target_meta = [
                'isDummy' => 'yes',
            ];
            $coinbaseDummyDOGEPayment->save();
        }
    }
}
