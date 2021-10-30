<template>
  <v-row justify="center">
    <v-col cols="12" class="pb-0">
      <v-btn text color="primary" :to="{ name: 'users' }" exact nuxt>Back to users</v-btn>
    </v-col>
    <v-col cols="12" sm="8" md="6">
      <h1>Edit user</h1>
      <UserDetailsForm
        :user="user"
        :loading="loading"
        with-password-fields
        :errors="errorMessages.user"
      >
        <template #card-actions>
          <v-spacer></v-spacer>
          <v-btn
            :loading="saving"
            color="primary"
            @click="saveUser"
          >
            Save
          </v-btn>
          <v-btn
            color="secondary"
            :to="{ name: 'users-id', params: { id: user.id } }"
            exact
            nuxt
          >
            Cancel
          </v-btn>
        </template>
      </UserDetailsForm>
    </v-col>
  </v-row>
</template>

<script lang="ts">
import Vue from 'vue'
import UserApi from '@/api/UserApi';
import UserDetailsForm from '@/components/users/UserDetailsForm.vue'
import { required, sameAs } from 'vuelidate/lib/validators'
import {validationMixin} from 'vuelidate'
import CombineErrorsMixin from '@/mixins/CombineErrorsMixin'
import {User, UserUpdateData} from '@/api/User'

export default Vue.extend({
  components: { UserDetailsForm },
  mixins: [validationMixin, CombineErrorsMixin],
  validations: {
    user: {
      last_name: { required },
      first_name: { required },
      email: { required },
      phone_number: { required },
      birthdate: { required },
      password_confirmation: {
        sameAsPassword: sameAs('password')
      },
    },
  },
  data() {
    return {
      loading: true,
      saving: false,
      user: null as User & UserUpdateData | null,
      errors: {},
    }
  },
  computed: {
    errorMessages(): any {
      return {
        user: {
          // There is no way to use vue mixins with typescript and not to get errors
          // @ts-ignore
          last_name: this.combineErrors(this.getVuelidateError(this.$v.user.last_name, 'Last name'), this.errors.last_name),
          // @ts-ignore
          first_name: this.combineErrors(this.getVuelidateError(this.$v.user.first_name, 'First name'), this.errors.last_name),
          // @ts-ignore
          patronymic: this.combineErrors(this.getVuelidateError(this.$v.user.patronymic, 'Patronymic'), this.errors.patronymic),
          // @ts-ignore
          email: this.combineErrors(this.getVuelidateError(this.$v.user.email, 'Email'), this.errors.email),
          // @ts-ignore
          phone_number: this.combineErrors(this.getVuelidateError(this.$v.user.phone_number, 'Phone number'), this.errors.phone_number),
          // @ts-ignore
          birthdate: this.combineErrors(this.getVuelidateError(this.$v.user.birthdate, 'Birthdate'), this.errors.birthdate),
          // @ts-ignore
          password: this.combineErrors(this.getVuelidateError(this.$v.user.password, 'Password'), this.errors.password),
          // @ts-ignore
          password_confirmation: this.combineErrors(this.getVuelidateError(this.$v.user.password_confirmation, 'Confirm password'), this.errors.password_confirmation),
        },
      }
    },
  },
  mounted() {
    this.loadUser()
  },
  methods: {
    async loadUser(): Promise<any> {
      this.loading = true
      const userApi = new UserApi(this.$axios)
      this.user = (await userApi.show(this.$route.params.id)).data.user
      this.user.password = null
      this.user.password_confirmation = null
      this.loading = false
    },
    async saveUser(): Promise<any> {
      this.$v.$touch()
      if (this.$v.$anyError) {
        return;
      }

      const userApi = new UserApi(this.$axios)
      try {
        this.errors = {}
        this.saving = true
        const { result, user } = (await userApi.update(this.$route.params.id, this.user as User)).data
        if (result) {
          this.$router.push({ name: 'users-id', params: { id: '' + user.id } })
        } else {
          this.errors = {
            email: 'Saving failed',
          }
        }
        this.saving = false
      } catch (e) {
        if (e.response && e.response.data.errors) {
          this.errors = e.response.data.errors
        }
      }
    },
  },
})
</script>
