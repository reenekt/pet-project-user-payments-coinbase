<template>
  <v-row justify="center">
    <v-col cols="12" class="pb-0">
      <v-btn text color="primary" :to="{ name: 'users' }" exact nuxt>Back to users</v-btn>
    </v-col>
    <v-col cols="12" sm="8" md="6">
      <UserDetailsForm :user="user" :loading="loading" readonly>
        <template #card-actions>
          <v-spacer></v-spacer>
          <v-btn
            color="primary"
            :to="{ name: 'users-id-payments', params: { id: user.id } }"
            exact
            nuxt
          >
            Payments
          </v-btn>
          <v-btn
            color="info"
            :to="{ name: 'users-id-edit', params: { id: user.id } }"
            exact
            nuxt
          >
            <v-icon>mdi-account-edit</v-icon>
            Edit
          </v-btn>

          <delete-user-confirm-modal :user="user" @confirm="deleteUser(user.id)">
            <template #activator="{ on, attrs }">
              <v-btn
                class="ml-2"
                color="error"
                v-bind="attrs"
                v-on="on"
              >
                <v-icon>mdi-delete</v-icon>
                Delete
              </v-btn>
            </template>
          </delete-user-confirm-modal>
        </template>
      </UserDetailsForm>
    </v-col>
  </v-row>
</template>

<script lang="ts">
import Vue from 'vue'
import UserApi from '@/api/UserApi';
import UserDetailsForm from '@/components/users/UserDetailsForm.vue'
import DeleteUserConfirmModal from '@/components/users/DeleteUserConfirmModal.vue'
import {User} from '@/api/User'

export default Vue.extend({
  components: { UserDetailsForm, DeleteUserConfirmModal },
  data() {
    return {
      loading: true,
      user: null as User | null,
    }
  },
  mounted() {
    this.loadUser()
  },
  methods: {
    async loadUser() {
      this.loading = true
      const userApi = new UserApi(this.$axios)
      this.user = (await userApi.show(this.$route.params.id)).data.user
      this.loading = false
    },
    async deleteUser(id: number | string) {
      const userApi = new UserApi(this.$axios)
      return userApi.delete(id)
        .then((_response) => {
          this.$router.push({ name: 'users' })
        })
    },
  },
})
</script>
