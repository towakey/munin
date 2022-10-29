<template>
  <v-layout
    column
    justify-center
  >
    <v-flex>
      <v-card>
        <v-card-title>投稿</v-card-title>
        <v-card-text>
          <v-text-field label="タイトル" v-model="title"></v-text-field>
          <v-text-field label="コンテンツ" v-model="contents"></v-text-field>
          <!-- <v-text-field label="タイプ" v-model="type"></v-text-field> -->
          <v-radio-group
            v-model="type"
            row
          >
            <v-radio
              label="note"
              value="note"
            ></v-radio>
            <v-radio
              label="memo"
              value="memo"
            ></v-radio>
            <v-radio
              label="address"
              value="address"
            ></v-radio>
          </v-radio-group>
        </v-card-text>
        <v-card-actions>
          <v-btn @click="listGet">LIST</v-btn>
          <v-spacer />
          <v-btn @click="submit">SUBMIT</v-btn>
        </v-card-actions>
      </v-card>
      <v-card v-for="value in this.response" :key="value.id">
        <v-card-title class="headline">
          {{ value.title }}
        </v-card-title>
        <v-card-text>
          <p>{{ value.contents }}</p>
          <p>{{ value.user_id }}</p>
        </v-card-text>
      </v-card>
    </v-flex>
  </v-layout>
</template>
<script>
export default {
  middleware: 'auth',
  name: "timeline",
  data(){
    return{
      title: "",
      contents: "",
      type: 0,
      response: "",
    }
  },
  created(){
    // console.log(this.$auth.user)
    // this.listGet()
  },
  mounted(){
    this.listGet()
  },
  methods: {
    async listGet(){
      try{
        await this.$axios.get("sanctum/csrf-cookie")
        await this.$axios
          .get("/api/note")
          .then((response)=>{
            this.response=response.data
          })
          console.log(this.response)
      }catch(error){
        console.log("listGet:"+error)
      }
    },
    async submit(){
      try{
        await this.$axios.$get("sanctum/csrf-cookie")
        await this.$axios
          .$post("/api/note/post", {
            title: this.title,
            contents: this.contents,
            type: this.type,
            // user_id: '',
          })
          .then((response)=>{
            console.log(response)
          })
        this.listGet()
      }catch(error){
        console.log("err:"+error)
      }
    }
  },
}
</script>
