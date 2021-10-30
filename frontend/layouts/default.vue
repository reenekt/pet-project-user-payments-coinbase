<template>
  <v-app>
    <v-navigation-drawer
      v-model="drawer"
      app
    >
      <v-list
        nav
        dense
      >
        <v-list-item-group
          v-model="selectedItem"
          color="primary"
        >
          <v-list-item
            v-for="(item, i) in items"
            :key="i"
            :to="item.to"
            nuxt
            exact
          >
            <v-list-item-icon>
              <v-icon v-text="item.icon"></v-icon>
            </v-list-item-icon>

            <v-list-item-content>
              <v-list-item-title v-text="item.text"></v-list-item-title>
            </v-list-item-content>
          </v-list-item>
        </v-list-item-group>
      </v-list>
    </v-navigation-drawer>

    <v-app-bar app>
      <v-app-bar-nav-icon @click="drawer = !drawer"></v-app-bar-nav-icon>

      <v-toolbar-title>Application</v-toolbar-title>

      <v-spacer></v-spacer>

      <v-menu bottom offset-y>
        <template v-slot:activator="{ on, attrs }">
          <v-avatar
            color="primary"
            v-bind="attrs"
            v-on="on"
          >
            <span class="white--text text-h5">{{ $auth.user && $auth.user.first_name[0] || '?' }}</span>
          </v-avatar>
        </template>

        <v-list>
          <v-list-item>
            <v-list-item-title>{{ $auth.user.last_name }} {{ $auth.user.first_name }} {{ $auth.user.patronymic }}</v-list-item-title>
          </v-list-item>
          <v-list-item :to="{name: 'users-id', params: { id: $auth.user.id }}" nuxt>
            <v-list-item-icon>
              <v-icon>mdi-account</v-icon>
            </v-list-item-icon>
            <v-list-item-title>Profile</v-list-item-title>
          </v-list-item>
          <v-divider></v-divider>
          <v-list-item @click="logout">
            <v-list-item-icon>
              <v-icon>mdi-logout</v-icon>
            </v-list-item-icon>
            <v-list-item-title>Logout</v-list-item-title>
          </v-list-item>
        </v-list>
      </v-menu>
    </v-app-bar>

    <v-main>
      <v-container>
        <Nuxt />
      </v-container>
    </v-main>
  </v-app>
</template>

<script>
export default {
  data () {
    return {
      drawer: null,

      selectedItem: 0,
      items: [
        { to: '/', text: 'Home', icon: 'mdi-home' },
        { to: { name: 'users' }, text: 'Users', icon: 'mdi-account-group' },
        {
          to: { name: 'users-id-payments', params: { id: this.$auth.user.id } },
          text: 'My Payments',
          icon: 'mdi-cash-multiple'
        },
      ],
    }
  },
  methods: {
    logout() {
      this.$auth.logout()
        .then((_response) => {
          this.$router.push({ name: 'login' })
        })
    },
  },
}
</script>
