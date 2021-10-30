<template>
  <v-row class="pb-15">
    <v-col cols="12">
      <h1 class="my-3">Payments of user {{ userFullName }}</h1>
      <v-data-table
        :headers="headers"
        :items="payments"
        :items-per-page="10"
        class="elevation-1"
        :loading="loading"
      >
        <template #item.from="{ item }">
          <nuxt-link :to="{ name: 'users-id', params: { id: item.user_from.id } }">
            {{ item.user_from.last_name }} {{ item.user_from.first_name }} {{ item.user_from.patronymic }}
          </nuxt-link>
        </template>
        <template #item.to="{ item }">
          <payment-to-cell :payment="item"></payment-to-cell>
        </template>
        <template #item.amount="{ item }">
          {{ item.amount }} {{ item.currency }}
        </template>
        <template #item.comment="{ item }">
          <payment-comment-cell :payment="item"></payment-comment-cell>
        </template>
        <template #item.status="{ item }">
          {{ item.status }}
        </template>
      </v-data-table>
    </v-col>
  </v-row>
</template>

<script lang="ts">
import Vue from 'vue'
import PaymentCommentCell from '@/components/users/payments/PaymentCommentCell.vue'
import PaymentToCell from '@/components/users/payments/PaymentToCell.vue'
import UserApi from '@/api/UserApi'
import PaymentApi from '@/api/PaymentApi'
import {DataTableHeader} from 'vuetify/types'
import {User} from '@/api/User'
import {Payment} from '@/api/Payment'

export default Vue.extend({
  components: { PaymentCommentCell, PaymentToCell },
  data() {
    return {
      loading: true,
      headers: [
        {
          text: 'ID',
          align: 'start',
          sortable: false,
          value: 'id',
        },
        { text: 'From', value: 'from', sortable: false },
        { text: 'To', value: 'to', sortable: false },
        { text: 'Amount', value: 'amount', sortable: false },
        { text: 'Comment', value: 'comment', sortable: false },
        { text: 'Status', value: 'status' },
      ] as DataTableHeader[],
      payments: [] as Payment[] | any[],
      user: null as User | null,
    }
  },
  mounted() {
    this.loadUser()
      .then(() => {
        this.loadPayments()
      })
  },
  computed: {
    userFullName(): string {
      if (!this.user) {
        return ''
      }

      return `${(this.user as User).last_name} ${(this.user as User).first_name} ${(this.user as User).patronymic || ''}`
    },
  },
  methods: {
    async loadUser() {
      this.loading = true
      const userApi = new UserApi(this.$axios)
      this.user = (await userApi.show(this.$route.params.id)).data.user
      this.loading = false
    },
    async loadPayments() {
      this.loading = true
      const paymentApi = new PaymentApi(this.$axios, (this.user as User).id)
      this.payments = (await paymentApi.all()).data
      this.loading = false
    },
  },
})
</script>
