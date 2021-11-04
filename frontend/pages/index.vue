<template>
  <v-row justify="center" align="center">
    <v-col cols="12" sm="8" md="6">
      <v-card>
        <v-card-title class="headline">
          Welcome
        </v-card-title>
        <v-card-text>
          <p>Pet project by <a href="https://github.com/reenekt">Andrew Sementsov</a></p>
        </v-card-text>
        <v-card-text>
          <!-- Next div is embed code from concrete coinbase checkout -->
          <div>
            <a class="buy-with-crypto"
               :data-custom="dataCustom"
               :href="testCheckoutLink">
              Test buy with Crypto
            </a>
            <script src="https://commerce.coinbase.com/v1/checkout.js?version=201807">
            </script>
          </div>
        </v-card-text>
        <v-card-actions>
          <v-spacer />
          <v-btn
            color="primary"
            href="https://github.com/reenekt/pet-project-user-payments-coinbase"
            target="_blank"
          >
            Github repo
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-col>
  </v-row>
</template>

<script lang="ts">
import Vue from 'vue'

export default Vue.extend({
  computed: {
    testCheckoutLink() {
      const checkoutId = this.$config.testCheckoutId
      return 'https://commerce.coinbase.com/checkout/' + checkoutId
    },
    dataCustom() {
      return `{"user_id":${this.$auth.user!.id}}`
    },
  },
})
</script>
