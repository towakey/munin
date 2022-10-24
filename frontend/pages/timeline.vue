<template>
  <h1>TIMELINE</h1>
  <!-- <h2>LoggedIn:{{$auth.LoggedIn}}</h2> -->
</template>
<script>
export default {
  middleware: 'auth',
  name: "timeline",
  created(){
    console.log(this.$auth.user)
  }
}
</script>
