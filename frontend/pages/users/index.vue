<template>
  <v-row class="pb-15">
    <v-col cols="12">
      <h1 class="my-3">Users</h1>
      <v-data-table
        :headers="headers"
        :items="users"
        :items-per-page="10"
        class="elevation-1"
        :loading="loading"
      >
        <template #item.actions="{ item }">
          <v-menu>
            <template #activator="{ on, attrs }">
              <v-btn
                icon
                v-bind="attrs"
                v-on="on"
              >
                <v-icon>mdi-dots-vertical</v-icon>
              </v-btn>
            </template>

            <v-list dense>
              <!-- Show -->
              <v-list-item :to="{ name: 'users-id', params: { id: item.id } }">
                <v-list-item-icon>
                  <v-icon>mdi-eye</v-icon>
                </v-list-item-icon>
                <v-list-item-title>Show</v-list-item-title>
              </v-list-item>

              <!-- Edit -->
              <v-list-item :to="{ name: 'users-id-edit', params: { id: item.id } }">
                <v-list-item-icon>
                  <v-icon>mdi-account-edit</v-icon>
                </v-list-item-icon>
                <v-list-item-title>Edit</v-list-item-title>
              </v-list-item>

              <!-- Delete -->
              <delete-user-confirm-modal :user="item" @confirm="deleteUser(item.id)">
                <template #activator="{ on, attrs }">
                  <v-list-item
                    v-bind="attrs"
                    v-on="on"
                  >
                    <v-list-item-icon>
                      <v-icon>mdi-delete</v-icon>
                    </v-list-item-icon>
                    <v-list-item-title>Delete</v-list-item-title>
                  </v-list-item>
                </template>
              </delete-user-confirm-modal>
            </v-list>
          </v-menu>
        </template>
      </v-data-table>
    </v-col>

    <v-btn
      color="primary"
      elevation="1"
      :to="{ name: 'users-create' }"
      fab
      bottom
      right
      fixed
    >
      <v-icon>mdi-plus</v-icon>
    </v-btn>
  </v-row>
</template>

<script lang="ts">
import Vue from 'vue'
import UserApi from '@/api/UserApi'
import {DataTableHeader} from 'vuetify/types'
import DeleteUserConfirmModal from '@/components/users/DeleteUserConfirmModal.vue'
import {User} from '@/api/User'

export default Vue.extend({
  components: { DeleteUserConfirmModal },
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
        { text: 'Last name', value: 'last_name' },
        { text: 'First name', value: 'first_name' },
        { text: 'Patronymic', value: 'patronymic' },
        { text: 'Email', value: 'email' },
        { text: 'Phone number', value: 'phone_number' },
        { text: 'Birth date', value: 'birthdate' },
        { text: '', sortable: false, value: 'actions' },
      ] as DataTableHeader[],
      users: [] as User[]|any[],
    }
  },
  mounted() {
    this.loadUsers()
  },
  methods: {
    async loadUsers() {
      this.loading = true
      const userApi = new UserApi(this.$axios)
      this.users = (await userApi.all()).data
      this.loading = false
    },
    async deleteUser(id: number | string) {
      const userApi = new UserApi(this.$axios)
      const promise = userApi.delete(id)
      promise.then(() => {
        this.loadUsers()
      })
      return promise
    },
  },
})
</script>
