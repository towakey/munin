<template>
  <v-app dark>
    <v-navigation-drawer
      v-model="drawer"
      :mini-variant="miniVariant"
      :clipped="clipped"
      fixed
      app
      style="background-color: rgba(191, 54, 12, .9);border-width: 1px;border-color: #FF6F00"
    >
      <v-list>
        <v-list-item
          v-for="(item, i) in items"
          :key="i"
          :to="item.to"
          router
          exact
        >
          <v-list-item-action>
            <v-icon>{{ item.icon }}</v-icon>
          </v-list-item-action>
          <v-list-item-content>
            <v-list-item-title>{{ item.title }}</v-list-item-title>
          </v-list-item-content>
        </v-list-item>
      </v-list>
    </v-navigation-drawer>
    <v-app-bar
      :clipped-left="clipped"
      fixed
      app
      style="background-color: rgba(191, 54, 12, .7)"
    >
      <v-app-bar-nav-icon @click.stop="drawer = !drawer" />
      <!-- <v-toolbar-title>{{ title }}</v-toolbar-title> -->
      <v-toolbar-title
        v-text="this.$auth.loggedIn ? this.$auth.user.name : 'munin system'"
      />
      <v-spacer />
      <v-btn
        v-if="this.$auth.loggedIn"
        @click="logout"
        outlined
        style="background-color: rgba(191, 54, 12, .7);border-width: 1px;border-color: #FF6F00"
      >LOGOUT</v-btn>
      <v-btn
        v-else to="/login"
        nuxt
        outlined
        style="background-color: rgba(191, 54, 12, .7);border-width: 1px;border-color: #FF6F00"
      >LOGIN</v-btn>
    </v-app-bar>
    <v-main>
      <v-container>
        <Nuxt />
      </v-container>
    </v-main>
    <v-navigation-drawer
      v-model="rightDrawer"
      :right="right"
      temporary
      fixed
    >
      <v-list>
        <v-list-item @click.native="right = !right">
          <v-list-item-action>
            <v-icon light>
              mdi-repeat
            </v-icon>
          </v-list-item-action>
          <v-list-item-title>Switch drawer (click me)</v-list-item-title>
        </v-list-item>
      </v-list>
    </v-navigation-drawer>
    <v-footer
      :absolute="!fixed"
      app
      style="background-color: rgba(191, 54, 12, .7)"
    >
      <span>&copy; {{ new Date().getFullYear() }}</span>
    </v-footer>
  </v-app>
</template>

<script>
export default {
  name: 'DefaultLayout',
  data () {
    return {
      clipped: false,
      drawer: false,
      fixed: false,
      items: [
        // {
        //   icon: 'mdi-apps',
        //   title: 'Welcome',
        //   to: '/'
        // },
        // {
        //   icon: 'mdi-chart-bubble',
        //   title: 'Inspire',
        //   to: '/inspire'
        // },
        {
          icon: 'mdi-apps',
          title: 'TIMELINE',
          to: '/timeline'
        },
        {
          icon: 'mdi-apps',
          title: 'USER',
          to: '/user'
        },
      ],
      miniVariant: false,
      right: true,
      rightDrawer: false,
      title: 'Vuetify.js'
    }
  },
  methods: {
    async logout()
    {
      try{
        await this.$auth.logout();
      }
      catch(e){}
    },
  },
}
</script>
