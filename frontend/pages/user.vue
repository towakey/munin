<template>
  <v-card>
    <v-card-title class="headline">{{ this.$auth.user.name }}</v-card-title>
  </v-card>
</template>
<script>
export default {
  middleware: 'auth',
  name: 'user',
}
</script>