<template>
  <v-card>
    <v-skeleton-loader v-if="loading" type="card-heading@2"></v-skeleton-loader>
    <template v-if="!loading">
      <v-card-text>
        <v-row>
          <v-col>
            <v-text-field
              :readonly="readonly"
              :error-messages="errors.last_name"
              label="Last name"
              v-model="user.last_name"
            ></v-text-field>
          </v-col>
          <v-col>
            <v-text-field
              :readonly="readonly"
              :error-messages="errors.first_name"
              label="First name"
              v-model="user.first_name"
            ></v-text-field>
          </v-col>
          <v-col>
            <v-text-field
              :readonly="readonly"
              :error-messages="errors.patronymic"
              label="Patronymic"
              v-model="user.patronymic"
            ></v-text-field>
          </v-col>
        </v-row>
        <v-row>
          <v-col>
            <v-text-field
              :readonly="readonly"
              :error-messages="errors.email"
              label="Email"
              v-model="user.email"
            ></v-text-field>
          </v-col>
          <v-col>
            <v-text-field
              :readonly="readonly"
              :error-messages="errors.phone_number"
              label="Phone number"
              v-model="user.phone_number"
            ></v-text-field>
          </v-col>
          <v-col>
            <birthdate-picker v-model="user.birthdate"></birthdate-picker>
          </v-col>
        </v-row>
        <v-row v-if="withPasswordFields">
          <v-col>
            <v-text-field
              type="password"
              :readonly="readonly"
              :error-messages="errors.password"
              label="Password"
              v-model="user.password"
            ></v-text-field>
          </v-col>
          <v-col>
            <v-text-field
              type="password"
              :readonly="readonly"
              :error-messages="errors.password_confirmation"
              label="Confirm password"
              v-model="user.password_confirmation"
            ></v-text-field>
          </v-col>
        </v-row>
      </v-card-text>

      <v-card-actions>
        <slot name="card-actions"></slot>
      </v-card-actions>
    </template>
  </v-card>
</template>

<script lang="ts">
import Vue, { PropType } from 'vue'
import BirthdatePicker from '@/components/users/BirthdatePicker.vue'
import {User, UserStoreData, UserUpdateData} from '@/api/User'

export default Vue.extend({
  name: 'UserDetailsForm',
  components: { BirthdatePicker },
  props: {
    user: {
      required: false,
      type: Object as PropType<
        | User
        | User & UserStoreData
        | User & UserUpdateData
        | null
      >,
      default: () => null,
    },
    loading: {
      required: false,
      type: Boolean,
      default: true,
    },
    readonly: {
      required: false,
      type: Boolean,
      default: false,
    },
    withPasswordFields: {
      required: false,
      type: Boolean,
      default: false,
    },
    errors: {
      required: false,
      type: Object,
      default: () => ({}),
    },
  },
})
</script>
