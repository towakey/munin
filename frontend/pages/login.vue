<template>
  <v-card>
    <v-card-title class="justify-center">
      LOGIN
    </v-card-title>
    <v-card-text>
      <v-text-field label="email" v-model="form.email"></v-text-field>
      <v-text-field label="password" v-model="form.password" type="password"></v-text-field>
    </v-card-text>
    <v-card-actions class="justify-center">
      <v-btn @click="login" color="blue" outlined class="mx-auto">LOGIN</v-btn>
    </v-card-actions>
  </v-card>
</template>

<script>
export default {
  data() {
    return {
      form: {
        email: "",
        password: "",
      }
    };
  },
  methods: {
    async login() {
      // console.log("login method");
      try{
        let response = await this.$auth.loginWith('local', {
          data: this.form
        })
        console.log(response);
      } catch (error) {
        console.log(error.response.data)
      }
    },
    // async login() {
    //   this.$axios
    //     .$post("/api/login", {
    //       email: this.email,
    //       password: this.password,
    //     })
    //     .then((response) => {
    //       console.log(response);
    //     });
    // },
  },
};
</script>
