<template>
  <div id="category-form" v-if="Offer.id != undefined">
    <form @submit.prevent="submitForm">
      <v-container>
        <v-layout>
          <v-flex xs12>
            <v-select
              v-model="selectedItems"
              :items="categories"
              attach
              chips
              label="Seleccione una categoría de su oferta"
              multiple
              item-text="name"
              item-value="id"
              required
              :error-messages="errorMessages"
            ></v-select>
          </v-flex>
        </v-layout>
        <div class="text-md-center">
          <v-btn type="submit" color="primary">
            Finalizar publicación <v-icon dark right>mdi-briefcase-upload-outline</v-icon>
          </v-btn>
        </div>
      </v-container>
      
    </form>
  </div>
</template>
<script>
import { mapActions, mapState } from 'vuex';
export default {
  data:()=> ({
    selectedItems:[],
    errorMessages:''
  }),
  created(){    
    this.list();   
  },
  methods:{
    ...mapActions('CategoryStore', ['list']),
    ...mapActions('EmployerOfferStore', ['attachCategory']),
    submitForm(){
      this.errorMessages = '';
      if(this.hasErrorSelectedItems){
        this.errorMessages = 'Seleccione almenos una opción!';
        setTimeout(() => {
          this.errorMessages = '';
        }, 3000)
        return;
      }
      const data = Object.assign({}, {selectedItems: this.selectedItems}, {offerID: this.Offer.id});      
      this.attachCategory(data);
    },
    setCategoriesIds(offer){
      let ids = [];      
      if(offer.categories){        
        offer.categories.map(item => {
          ids.push(item.id);
        });
      }      
      return ids;
    }
  },  
  computed:{
    ...mapState('CategoryStore', ['categories']),
    ...mapState('EmployerOfferStore', ['Offer', 'saved','step']),    
    hasErrorSelectedItems(){
      if(!this.selectedItems.length){
        return true; //tiene error
      }       
      return false;
    }
  },
  watch:{
    saved(val){            
      if(val === true && this.step == 3){              
        this.$router.push({name:'employer.offers'});
      }
    },
    Offer(val){
      if(this.$route.name == 'employer.offers.edit'){        
        this.selectedItems = this.setCategoriesIds(this.Offer);      
      }    
    }
  }
}
</script>
