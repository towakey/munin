<template>
  <v-row>
    <v-col class="text-center">
      <v-text-field label="email" v-model="form.email"></v-text-field>
      <v-text-field label="password" v-model="form.password"></v-text-field>
      <v-btn @click="login" color="blue" outlined>LOGIN</v-btn>
    </v-col>
  </v-row>
</template>

<script>
export default {
  auth: false,
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
      console.log("login method");
      try{
        let response = await this.$auth.loginWith('local', {
          data: this.form
        })
        console.log(response);
      } catch (error) {
        console.log('error:'+error)
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
