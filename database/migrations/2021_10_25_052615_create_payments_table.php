<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->text('comment')->nullable();
            $table->foreignId('user_from_id')
                ->constrained('users')
                ->onUpdate('cascade')
                ->onDelete('set null');
            $table->string('status'); // pending, done, fail, cancelled
            $table->string('amount'); // string type is more safe for money than float/double
            $table->string('currency'); // fiat (USD, RUB) or crypto (BTC, DOGE)
            $table->string('target_type'); // crypto_wallet or (not implemented) other methods like credit_card, paypal, etc
            $table->text('target'); // json with crypto wallet address or bank details for transfer
            $table->text('target_meta'); // json
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payments');
    }
}
