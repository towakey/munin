<template>
  <v-layout
    column
    justify-center
  >
    <!-- {{ this.$route.query.id }} -->
    <v-flex>
      <v-card
       outlined
        elevation="0"
        style="background-color: rgba(191, 54, 12, .3);border-width: 1px;border-color: #FF6F00"
      >
        <v-card-title class="headline">{{this.item.title}}</v-card-title>
        <v-card-subtitle>
          <v-chip
            outlined
            style="border-width: 1px;border-color: #FF6F00"
          >{{ this.item.type }}</v-chip>
          <v-chip
            outlined
            style="border-width: 1px;border-color: #FF6F00"
          >{{ this.item.id }}</v-chip>
          <v-chip
            outlined
            style="border-width: 1px;border-color: #FF6F00"
          >{{ this.item.secret }}</v-chip>
        </v-card-subtitle>
        <v-card-text>
          <div v-html='$md.render(String(this.item.contents))'></div>
        </v-card-text>
      </v-card>
    </v-flex>
  </v-layout>
</template>
<script>
export default {
  data(){
    return{
      item: "",
    }
  },
  mounted() {
    console.log(this.$route.query.id)
    this.getItem()
  },
  methods: {
    async getItem(){
      try{
        await this.$axios.get("sanctum/csrf-cookie")
        await this.$axios
          .post("/api/note/getItem", {
            id: this.$route.query.id
          })
          .then((response)=>{
            this.item = response.data
          })
          console.log(this.item)
      }catch(error){
        console.log(error)
      }
    }
  },
}
</script>