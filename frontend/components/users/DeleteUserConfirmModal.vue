<template>
  <v-dialog
    v-model="dialog"
    width="500"
  >
    <template v-slot:activator="{ on, attrs }">
      <slot name="activator" v-bind="{ on, attrs }"></slot>
    </template>

    <v-card>
      <v-card-title class="text-h5">
        Delete user
      </v-card-title>

      <v-card-text>
        Are you sure that you want to delete user
        {{ user.last_name }} {{ user.first_name }} {{ user.patronymic }}?
      </v-card-text>

      <v-divider></v-divider>

      <v-card-actions>
        <v-spacer></v-spacer>
        <v-btn
          color="error"
          text
          @click="$emit('confirm', user)"
        >
          Yes
        </v-btn>
        <v-btn
          color="secondary"
          text
          @click="dialog = false"
        >
          No
        </v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>

<script lang="ts">
import Vue, {PropType} from 'vue'
import { User } from '@/api/User'

export default Vue.extend({
  name: 'DeleteUserConfirmModal',
  props: {
    user: {
      required: true,
      type: Object as PropType<User>,
    },
  },
  data() {
    return {
      dialog: false,
    }
  },
})
</script>
