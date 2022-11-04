<template>
  <v-card
    outlined
    style="background-color: rgba(191, 54, 12, .3);border-width: 1px;border-color: #FF6F00"
  >
    <v-card-title class="headline">{{ this.$auth.user.name }}</v-card-title>
    <v-card-text>
      <p>{{ this.$auth.user.id }}</p>
    </v-card-text>
  </v-card>
</template>
<script>
export default {
  middleware: 'auth',
  name: 'user',
}
</script>