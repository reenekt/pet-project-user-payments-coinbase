<template>
  <v-row justify="center">
    <v-col cols="12" sm="8" md="6">
      <v-card>
        <v-card-text>
          <form @submit.prevent="login">
            <v-text-field
              v-model="credentials.login"
              :error-messages="combineErrors(getVuelidateError($v.credentials.login, 'Login'), errors.login, errors.auth)"
              label="Email / phone number"
              required
              @input="$v.credentials.login.$dirty && $v.credentials.login.$touch()"
              @blur="$v.credentials.login.$dirty && $v.credentials.login.$touch()"
            ></v-text-field>
            <v-text-field
              v-model="credentials.password"
              :error-messages="combineErrors(getVuelidateError($v.credentials.password, 'Login'), errors.password)"
              label="Password"
              required
              type="password"
              @input="$v.credentials.password.$dirty && $v.credentials.password.$touch()"
              @blur="$v.credentials.password.$dirty && $v.credentials.password.$touch()"
            ></v-text-field>
            <v-btn color="primary" type="submit">Login</v-btn>
          </form>
        </v-card-text>
      </v-card>
    </v-col>
  </v-row>
</template>

<script lang="ts">
import Vue from 'vue'
import { validationMixin } from 'vuelidate'
import { required } from 'vuelidate/lib/validators'
import CombineErrorsMixin from '@/mixins/CombineErrorsMixin'

export default Vue.extend({
  layout: 'auth',
  auth: 'guest',
  mixins: [validationMixin, CombineErrorsMixin],
  validations: {
    credentials: {
      login: { required },
      password: { required },
    },
  },
  data() {
    return {
      credentials: {
        login: '',
        password: '',
      },
      errors: {},
    }
  },
  methods: {
    async login() {
      this.$v.$touch()
      if (this.$v.$anyError) {
        return;
      }

      this.errors = {}
      return this.$auth.loginWith('local', { data: this.credentials })
        .then((_response) => {
          this.$router.push('/')
        })
        .catch((error) => {
          this.errors = error.response.data.errors
        })
    },
  },
})
</script>
