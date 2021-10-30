<template>
  <span v-if="payment.comment.length < 100" v-text="payment.comment"></span>
  <v-dialog v-model="dialog" v-else>
    <template #activator="{ on, attrs }">
      <v-btn
        text
        color="info"
        v-on="on"
        v-bind="attrs"
      >
        Show comment
      </v-btn>
    </template>

    <v-card>
      <v-card-text v-text="payment.comment"></v-card-text>
    </v-card>
  </v-dialog>
</template>

<script lang="ts">
import Vue, {PropType} from 'vue'
import {Payment} from '@/api/Payment'

export default Vue.extend({
  name: 'PaymentCommentCell',
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
