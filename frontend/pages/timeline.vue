<template>
  <v-layout
    column
    justify-center
  >
    <v-flex>
      <v-card>
        <v-card-title>投稿</v-card-title>
        <v-card-text>
          <v-text-field label="TITLE" v-model="title"></v-text-field>
          <v-textarea label="CONTENTS" v-model="contents"></v-textarea>
          <!-- <v-text-field label="コンテンツ" v-model="contents"></v-text-field> -->
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
          <p>TYPE:{{ value.type }}</p>
          <p>ID:{{ value.id }}</p>
        </v-card-text>
        <v-card-actions>
          <v-btn @click="dialog_open(value.id,value.title,value.contents,value.type,value.secret,value.node_from,value.node_to)">UPDATE</v-btn>
          <v-spacer />
          <!-- <v-btn @click="destroy(value.id)">DELETE</v-btn> -->
          <v-btn @click="delete_check(value.id)">DELETE</v-btn>
        </v-card-actions>
      </v-card>
    </v-flex>
    <v-dialog
      v-model="delete_dialog"
    >
      <v-card>
        <v-card-title>削除しますか？</v-card-title>
        <v-card-text>
        </v-card-text>
        <v-card-actions>
          <v-btn @click="delete_yes">YES</v-btn>
          <v-spacer />
          <v-btn @click="delete_no">NO</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
    <v-dialog
      v-model="dialog"
    >
      <v-card>
        <v-card-title>
          <v-text-field v-model="update_title"></v-text-field>
        </v-card-title>
        <v-card-text>
          <v-textarea v-model="update_contents"></v-textarea>
        </v-card-text>
        <v-card-actions>
          <v-btn @click="dialog_update">UPDATE</v-btn>
          <v-spacer />
          <v-btn @click="dialog_cancel">CANCEL</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>

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
      type: "note",
      secret: "public",
      node_from: "",
      node_to: "",
      response: "",

      dialog: false,
      delete_dialog: false,

      update_id: "",
      update_title: "",
      update_contents: "",
      update_type: "",
      update_secret: "",
      update_node_from: "",
      update_node_to: "",

      delete_id: "",
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
            secret: this.secret,
            node_from: this.node_from,
            node_to: this.node_to,
            // user_id: '',
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
        this.listGet()
      }catch(error){
        console.log("err:"+error)
      }
    },
    delete_check(id){
      this.delete_id=id
      this.delete_dialog=true
    },
    delete_no(){
      this.delete_dialog=false
    },
    delete_yes(){
      this.destroy(this.delete_id)
      this.delete_id=""
      this.delete_dialog=false
    },
    async destroy(id){
      try{
        await this.$axios.get("sanctum/csrf-cookie")
        console.log(id)
        await this.$axios
          .$post("/api/note/destroy", {
            delete_id: id,
          })
          .then((response)=>{
            console.log(response)
          })
        this.listGet()
      }catch(error){
        console.log("err:"+error)
      }
    },
    dialog_open(id, title, contents, type, secret, node_from, node_to){
      this.dialog=true
      this.update_id=id
      this.update_title=title
      this.update_contents=contents
      this.update_type=type
      this.update_secret=secret
      this.update_node_from=node_from
      this.update_node_to=node_to
    },
    dialog_cancel(){
      this.dialog=false
      this.update_id=""
      this.update_title=""
      this.update_contents=""
      this.update_type=""
      this.update_secret=""
      this.update_node_from=""
      this.update_node_to=""
    },
    async dialog_update(){
      try{
        await this.$axios.$get("sanctum/csrf-cookie")
        await this.$axios
          .$post("/api/note/update", {
            id: this.update_id,
            title: this.update_title,
            contents: this.update_contents,
            type: this.update_type,
            secret: this.update_secret,
            node_from: this.update_node_from,
            node_to: this.update_node_to,
          })
          .then((response)=>{
            console.log(response)
          })
        this.update_id=""
        this.update_title=""
        this.update_contents=""
        this.update_type=""
        this.update_secret=""
        this.update_node_from=""
        this.update_node_to=""
        this.dialog=false
        this.listGet()
      }catch(error){
        console.log("err:"+error)
        this.dialog=false
      }
    }
  },
}
</script>
