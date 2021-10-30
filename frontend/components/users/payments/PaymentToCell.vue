<template>
  <div>
    <template v-if="payment.target_type === 'crypto_wallet' || payment.target_type === 'coinbase'">
      <div>
        Crypto wallet ({{ payment.currency }}) <span v-if="payment.target_type === 'coinbase'"> (via Coinbase)</span>
        <span class="text--light-blue">{{ payment.target.wallet_address || 'Unknown wallet address' }}</span>
        <v-dialog
          v-if="payment.target_type === 'coinbase'"
          width="500"
        >
          <template #activator="{ on, attrs }">
            <v-btn
              text
              color="info"
              small
              v-on="on"
              v-bind="attrs"
            >
              Show details
            </v-btn>
          </template>

          <v-card>
            <v-card-title>Payment target details</v-card-title>
            <v-card-text>
              <v-simple-table
                v-if="Object.keys(payment.target).length > 0"
                dense
              >
                <tbody>
                <tr v-if="payment.target.wallet_address">
                  <td>Wallet address</td>
                  <td>{{ payment.target.wallet_address }}</td>
                </tr>
                <tr v-if="payment.target.wallet_currency">
                  <td>Wallet currency</td>
                  <td>{{ payment.target.wallet_currency }}</td>
                </tr>
                <tr v-if="payment.target.coinbase_charge_code">
                  <td>Coinbase charge code</td>
                  <td>{{ payment.target.coinbase_charge_code }}</td>
                </tr>
                <tr v-if="payment.target.coinbase_charge_uuid">
                  <td>Coinbase charge UUID</td>
                  <td>{{ payment.target.coinbase_charge_uuid }}</td>
                </tr>
                <tr v-if="payment.target.coinbase_checkout_uuid">
                  <td>Coinbase checkout UUID</td>
                  <td>{{ payment.target.coinbase_checkout_uuid }}</td>
                </tr>
                </tbody>
              </v-simple-table>
            </v-card-text>
          </v-card>
        </v-dialog>
      </div>
    </template>
    <div v-else>Unknown</div>
  </div>
</template>

<script lang="ts">
import Vue, {PropType} from 'vue'
import {Payment} from '@/api/Payment'

export default Vue.extend({
  name: 'PaymentToCell',
  props: {
    payment: {
      required: true,
      type: Object as PropType<Payment>,
    }
  },
  data() {
    return {
      dialog: false,
    }
  },
})
</script>

<style scoped>

</style>
