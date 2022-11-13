<template>
  <v-dialog v-model="isUpdateUserInfoDialog">
    <v-card>
      <v-card-title>
        ユーザー情報編集
      </v-card-title>
      <v-card-text>
        <p>{{ this.$auth.user.id }}</p>
        <v-text-field label="ユーザー名" v-model="name"></v-text-field>
        <v-text-field label="E-MAIL" v-model="email"></v-text-field>
        <p>{{ this.$auth.user.created_at }}</p>
      </v-card-text>
      <v-card-actions>
        <v-btn
          @click="changeUserInfo"
          outlined
          class="mx-auto"
        >完了</v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>
<script>
export default {
  data: () => ({
    isUpdateUserInfoDialog: false,
    name: "",
    email: "",
  }),
  created(){
    this.name = this.$auth.user.name
    this.email = this.$auth.user.email
  },
  methods: {
    async changeUserInfo() {
      try{
        await this.$axios.$get("sanctum/csrf-cookie")
        await this.$axios
          .$post("/api/user/update", {
            id: this.$auth.user.id,
            name: this.name,
            email: this.email,
          })
          .then((response)=>{
            console.log(response)
          })
        this.name = this.$auth.user.name
        this.email = this.$auth.user.email
        this.isUpdateUserInfoDialog=false
      }catch(error){
        console.log("err:"+error)
        this.isUpdateUserInfoDialog=false
      }
    }
  }
}
</script>
