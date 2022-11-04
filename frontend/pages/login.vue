<template>
  <v-card
    outlined
    style="background-color: rgba(191, 54, 12, .3);border-width: 1px;border-color: #FF6F00">
    <v-card-title class="justify-center">
      LOGIN
    </v-card-title>
    <v-card-text>
      <v-text-field label="email" v-model="form.email"></v-text-field>
      <v-text-field label="password" v-model="form.password" type="password"></v-text-field>
    </v-card-text>
    <v-card-actions class="justify-center">
      <v-btn
        @click="login"
        outlined
        class="mx-auto black--text"
        style="background-color: rgba(191, 54, 12, .7);border-width: 1px;border-color: #FF6F00"
      >LOGIN</v-btn>
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
