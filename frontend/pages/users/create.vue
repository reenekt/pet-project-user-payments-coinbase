<template>
  <v-row justify="center">
    <v-col cols="12" class="pb-0">
      <v-btn text color="primary" :to="{ name: 'users' }" exact nuxt>Back to users</v-btn>
    </v-col>
    <v-col cols="12" sm="8" md="6">
      <h1>Create user</h1>
      <UserDetailsForm
        :user="user"
        :loading="false"
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
            :to="{ name: 'users' }"
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
import UserApi from '@/api/UserApi'
import UserDetailsForm from '@/components/users/UserDetailsForm.vue'
import {validationMixin} from 'vuelidate'
import { required, sameAs } from 'vuelidate/lib/validators'
import CombineErrorsMixin from '@/mixins/CombineErrorsMixin'
import { User, UserStoreData } from '@/api/User'

export default Vue.extend({
  components: { UserDetailsForm },
  mixins: [validationMixin, CombineErrorsMixin],
  validations() {
    return {
      user: {
        last_name: { required },
        first_name: { required },
        email: { required },
        phone_number: { required },
        birthdate: { required },
        password: { required },
        password_confirmation: { required, sameAsPassword: sameAs('password') },
      },
    }
  },
  data() {
    return {
      saving: false,
      user: {
        last_name: '',
        first_name: '',
        patronymic: null,
        email: '',
        phone_number: '',
        birthdate: '',
        password: '',
        password_confirmation: '',
      } as User & UserStoreData,
      errors: {} as any,
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
  methods: {
    async saveUser(): Promise<void> {
      this.$v.$touch()
      if (this.$v.$anyError) {
        return;
      }

      const userApi = new UserApi(this.$axios)
      try {
        this.errors = {}
        this.saving = true
        const { result, user } = (await userApi.store(this.user as UserStoreData)).data
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
