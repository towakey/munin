<template>
  <v-row>
    <v-col class="text-center">
      <v-text-field label="email" v-model="email"></v-text-field>
      <v-text-field label="password" v-model="password"></v-text-field>
      <v-btn @click="login" color="blue" outlined>LOGIN</v-btn>
    </v-col>
  </v-row>
</template>

<script>
export default {
  data() {
    return {
      email: "",
      password: "",
    };
  },
  methods: {
    login() {
      console.log("login methods");
      this.$axios
        .$post("/api/login", {
          email: this.email,
          password: this.password,
        })
        .then((response) => {
          console.log(response);
        });
    },
  },
};
</script>
