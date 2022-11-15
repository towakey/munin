<template>
  <v-layout
    column
    justify-center
  >
    <v-flex>
      <PostForm @listGet="listGet" />
      <v-expansion-panels style="padding-bottom: 5px">
        <v-expansion-panel
          style="background-color: rgba(191, 54, 12, .3);border-width: 1px;border-color: #FF6F00"
        >
          <v-expansion-panel-header
          outlined
          style="background-color: rgba(191, 54, 12, .3)"
          >
          検索オプション
          </v-expansion-panel-header>
          <v-expansion-panel-content
            style="padding-top:10px"
          >
            <v-card>
              <v-card-title>
              </v-card-title>
              <v-card-text
                class="d-flex"
              >
                <v-checkbox
                  v-model="selectType"
                  label="note"
                  value="note"
                >
                </v-checkbox>
                <v-checkbox
                  v-model="selectType"
                  label="memo"
                  value="memo"
                >
                </v-checkbox>
                <v-checkbox
                  v-model="selectType"
                  label="address"
                  value="address"
                >
                </v-checkbox>
              </v-card-text>
              <v-card-actions>
                <v-btn
                  @click="listGet"
                  outlined
                  style="background-color: rgba(191, 54, 12, .7);border-width: 1px;border-color: #FF6F00"
                >LIST</v-btn>
                <v-spacer />
                <v-btn
                  @click="dialog_secret"
                  outlined
                  style="background-color: rgba(191, 54, 12, .7);border-width: 1px;border-color: #FF6F00"
                >SECRET</v-btn>
              </v-card-actions>
            </v-card>
          </v-expansion-panel-content>
        </v-expansion-panel>
      </v-expansion-panels>
      <v-card
        v-for="value in this.response"
        :key="value.id"
        outlined
        elevation="0"
        style="background-color: rgba(191, 54, 12, .3);border-width: 1px;border-color: #FF6F00"
      >
        <v-card-title class="headline">
          {{ value.title }}
        </v-card-title>
        <v-card-subtitle>
          <v-chip
            outlined
            style="border-width: 1px;border-color: #FF6F00"
          >{{ value.type }}</v-chip>
          <v-chip
            outlined
            style="border-width: 1px;border-color: #FF6F00"
          >{{ value.id }}</v-chip>
          <v-chip
            outlined
            style="border-width: 1px;border-color: #FF6F00"
          >{{ value.secret }}</v-chip>
        </v-card-subtitle>
        <v-card-text>
          <div v-html='$md.render(String(value.contents))'></div>
          <!-- <p>{{ value.contents }}</p> -->
          <!-- <p>TYPE:{{ value.type }}</p>
          <p>ID:{{ value.id }}</p> -->
        </v-card-text>
        <v-card-actions>
          <v-btn
            @click="dialog_open(value.id,value.title,value.contents,value.type,value.secret,value.node_from,value.node_to)"
            outlined
            style="background-color: rgba(191, 54, 12, .7);border-width: 1px;border-color: #FF6F00"
          >UPDATE</v-btn>
          <v-btn
            @click="moveView(value.id)"
            outlined
            style="background-color: rgba(191, 54, 12, .7);border-width: 1px;border-color: #FF6F00"
            nuxt
          >VIEW</v-btn>
          <v-spacer />
          <!-- <v-btn @click="destroy(value.id)">DELETE</v-btn> -->
          <v-btn
            @click="delete_check(value.id)"
            outlined
            color="red"
          >DELETE</v-btn>
        </v-card-actions>
      </v-card>
    </v-flex>
    <v-dialog
      v-model="delete_dialog"
    >
      <v-card
        outlined
        style="background-color: rgba(191, 54, 12, .9);border-width: 1px;border-color: #FF6F00"
      >
        <v-card-title>削除しますか？</v-card-title>
        <v-card-text>
        </v-card-text>
        <v-card-actions>
          <v-btn
            @click="delete_yes"
            outlined
          >YES</v-btn>
          <v-spacer />
          <v-btn
            @click="delete_no"
            outlined
          >NO</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
    <v-dialog
      v-model="dialog"
    >
      <v-card
        outlined
        style="background-color: rgba(191, 54, 12, .9);border-width: 1px;border-color: #FF6F00"
        class=".col-9"
      >
        <v-card-title>
          <v-text-field label="TITLE" v-model="update_title"></v-text-field>
        </v-card-title>
        <v-card-text>
          <v-textarea label="CONTENTS" v-model="update_contents"></v-textarea>
        </v-card-text>
        <v-card-actions>
          <v-btn
            @click="dialog_update"
            outlined
          >UPDATE</v-btn>
          <v-spacer />
          <v-btn
            @click="dialog_cancel"
            outlined
          >CANCEL</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
    <v-dialog
      v-model="secret_dialog"
    >
      <v-card
        outlined
        style="background-color: rgba(191, 54, 12, .9);border-width: 1px;border-color: #FF6F00"
      >
        <v-card-title>
          Please Enter Password
        </v-card-title>
        <v-card-text>
          <v-text-field label="" v-model="secret_password" type="password"></v-text-field>
        </v-card-text>
        <v-card-actions class="justify-center">
          <v-btn
            @click="listGetSecret"
            outlined
            class="mx-auto"
          >ENTER</v-btn>
          <v-spacer />
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
      response: "",
      selectType: ["note", "memo", "address"],

      dialog: false,
      delete_dialog: false,
      secret_dialog: false,

      update_id: "",
      update_title: "",
      update_contents: "",
      update_type: "",
      update_secret: "",
      update_node_from: "",
      update_node_to: "",

      delete_id: "",

      secret_password: "",
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
    moveView(id){
      console.log(id)
      this.$router.push({path: 'timeline/view', query: {id: id}})
    },
    async listGet(){
      try{
        await this.$axios.get("sanctum/csrf-cookie")
        await this.$axios
          .post("/api/note", {
            selectType: this.selectType
          })
          .then((response)=>{
            this.response=response.data
          })
          console.log(this.response)
      }catch(error){
        console.log("listGet:"+error)
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
    },
    dialog_secret(){
      this.secret_dialog=true
    },
    async listGetSecret(){
      try{
        await this.$axios.get("sanctum/csrf-cookie")
        await this.$axios
          .post("/api/note/secret",{
            password: this.secret_password,
          })
          .then((response)=>{
            this.response=response.data
          })
          console.log(this.response)
      }catch(error){
        this.response=""
        console.log("listGetSecret:"+error)
      }
      this.secret_password=""
      this.secret_dialog=false
    },
  },
}
</script>
