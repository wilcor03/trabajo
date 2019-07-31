<template>
  <v-app>            
    <router-view></router-view>    
    <Footer/>
  </v-app>
</template>
<script>
import Footer from './Footer.vue';
export default {
    components:{Footer},    
}
</script>