<template>
  <v-card>
    <v-card-title>投稿</v-card-title>
    <v-card-text>
      <v-text-field label="タイトル" v-model="title"></v-text-field>
      <v-text-field label="コンテンツ" v-model="contents"></v-text-field>
      <v-text-field label="タイプ" v-model="type"></v-text-field>
    </v-card-text>
    <v-card-actions>
      <v-spacer />
      <v-btn @click="submit">SUBMIT</v-btn>
    </v-card-actions>
  </v-card>
</template>
<script>
export default {
  middleware: 'auth',
  name: "timeline",
  data(){
    return{
      title: "",
      contents: "",
      type: "",
    }
  },
  created(){
    // console.log(this.$auth.user)
  },
  methods: {
    async submit(){
      try{
        await this.$axios.get("sanctum/csrf-cookie")
        await this.$axios
          .$post("/api/note/post", {
            title: this.title,
            contents: this.contents,
            type: this.type,
            user_id: 'kyos',
          })
          .then((response)=>{
            console.log(response)
          })
      }catch(error){
        console.log("err:"+error)
      }
    }
  },
}
</script>
