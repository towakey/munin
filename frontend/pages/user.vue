<template>
  <div>
    <v-card
      outlined
      style="background-color: rgba(191, 54, 12, .3);border-width: 1px;border-color: #FF6F00"
    >
      <v-card-title class="headline">{{ this.$auth.user.name }}</v-card-title>
      <v-card-text>
        <p>{{ this.$auth.user.id }}</p>
        <p>{{ this.$auth.user.email }}</p>
      </v-card-text>
      <v-card-actions>
        <v-btn
          @click="openUpdateUserInfoDialog"
          outlined
          class="mx-auto"
        >編集</v-btn>
      </v-card-actions>
    </v-card>
    <UpdateUserInfo ref="uui" />
  </div>
</template>
<script>
import UpdateUserInfo from '@/components/UpdateUserInfo'
export default {
  middleware: 'auth',
  name: 'user',
  components: {
    UpdateUserInfo
  },
  methods: {
    openUpdateUserInfoDialog() {
      this.$refs.uui.isUpdateUserInfoDialog = true
    }
  }
}
</script>