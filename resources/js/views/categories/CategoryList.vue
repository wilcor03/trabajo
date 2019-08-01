<template>
  <div id="lists"> 
    <div v-if="loading">
      <v-progress-linear :indeterminate="true"></v-progress-linear>
    </div>
    <v-layout row wrap v-if="isLoaded">
      <v-flex xs12 sm6 v-for="category of categories" :key="category.id">
        <v-checkbox
          v-model.lazy="cats"   
          :disabled="loading"           
          :label="category.name"
          color="red"
          :value="category.id"              
          hide-details
          @click="submit(category)"
        ></v-checkbox>
      </v-flex>
    </v-layout>    
  </div>
</template>
<script>
import { createNamespacedHelpers } from 'vuex';
const { mapState, mapActions, mapGetters } = createNamespacedHelpers('CategoryStore');
export default {
    data(){
      return {
        cats:[]        
      }
    },
    computed:{
        ...mapState(['categories', 'loading']),
        ...mapGetters(['selectedCats']),
        isLoaded(){
          if(this.selectedCats){
            this.cats = this.selectedCats
            return true
          }
        }
    },
    methods:{
        ...mapActions(['list', 'myCategories', 'attach']),
        submit(cat){
          this.attach(cat).then(saved => {
            this.cats = this.selectedCats
          })
        }
    },
    created(){        
      this.list();                              
    }    
}
</script>