<template>
  <v-card>
    <v-vard-title class="headline">{{ this.$auth.user.name }}</v-vard-title>
  </v-card>
</template>
<script>
export default {
  middleware: 'auth',
  name: 'user',
}
</script>