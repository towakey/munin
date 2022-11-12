<template>
  <v-expansion-panels style="padding-bottom: 5px">
    <v-expansion-panel
      style="background-color: rgba(191, 54, 12, .3);border-width: 1px;border-color: #FF6F00"
    >
      <v-expansion-panel-header
      outlined
      style="background-color: rgba(191, 54, 12, .3)"
      >
        投稿する
      </v-expansion-panel-header>
      <v-expansion-panel-content
        style="padding-top:10px"
      >
        <v-card
          outlined
          style="background-color: rgba(191, 54, 12, .3);border-width: 1px;border-color: #FF6F00"
        >
          <v-card-text>
            <v-text-field label="TITLE" v-model="title"></v-text-field>
            <v-textarea label="CONTENTS" v-model="contents"></v-textarea>
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
            <v-radio-group
              v-model="secret"
              row
            >
              <v-radio
                label="一般"
                value="public"
              ></v-radio>
              <v-radio
                label="機密"
                value="private"
              ></v-radio>
            </v-radio-group>
          </v-card-text>
          <v-card-actions>
            <v-spacer />
            <v-btn
              @click="submit"
              outlined
              style="background-color: rgba(191, 54, 12, .7);border-width: 1px;border-color: #FF6F00"
            >SUBMIT</v-btn>
          </v-card-actions>
        </v-card>  
      </v-expansion-panel-content>
    </v-expansion-panel>
  </v-expansion-panels>
</template>
<script>
export default {
  data(){
    return{
      title: "",
      contents: "",
      type: "note",
      secret: "public",
      node_from: "",
      node_to: "",
    }
  },
  methods: {
    async submit(){
      try{
        console.log("PostForm.vue submit")
        await this.$axios.$get("sanctum/csrf-cookie")
        await this.$axios
          .$post("/api/note/post", {
            title: this.title,
            contents: this.contents,
            type: this.type,
            secret: this.secret,
            node_from: this.node_from,
            node_to: this.node_to,
          })
          .then((response)=>{
            console.log(response)
          })
        this.title=""
        this.contents=""
        this.type="note"
        this.secret="public"
        this.node_from=""
        this.node_to=""
        this.$emit('listGet')
      }catch(error){
        console.log("err:"+error)
      }
    },
  }
}
</script>