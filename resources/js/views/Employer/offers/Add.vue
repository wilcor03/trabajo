<template>
<div id="offers-add">
  <v-layout row wrap>
    <v-flex xs12 sm6 offset-sm3>
      <v-card>
        <v-toolbar color="light-blue">
          <v-toolbar-side-icon @click="goBack()"><v-icon color="white">mdi-arrow-left</v-icon></v-toolbar-side-icon>        
          <v-toolbar-title class="white--text">{{ currentTitle }}</v-toolbar-title>
        </v-toolbar>        

        <v-window v-model="step">
          <v-window-item :value="1">
            <v-card-text>
              <offer-form/>
            </v-card-text>
          </v-window-item>

          <v-window-item :value="2">
            <v-card-text>
              <offer-scope-form/>
            </v-card-text>
          </v-window-item>

          <v-window-item :value="3">  
            <v-card-text>
              <category-form/>        
            </v-card-text>      
          </v-window-item>
        </v-window>

        <v-divider></v-divider>

        <v-card-actions>
          <v-btn
            :disabled="step === 1"
            flat
            @click="setStep('back')"
            depressed
          >
            <v-icon lelft dark>mdi-arrow-left</v-icon>  Atras
          </v-btn>
          <v-spacer></v-spacer>
          <v-btn 
            v-if="step != 3"       
            :disabled="globalLoading"
            :loading="globalLoading"
            color="primary"
            depressed
            @click="submitInfo"
          >
            Continuar <v-icon right dark>mdi-arrow-right</v-icon>
          </v-btn>
        </v-card-actions>

      </v-card>
    </v-flex>
  </v-layout>
</div>
</template>
<script>
import OfferForm from '../../../components/employer/OfferForm';
import OfferScopeForm from '../../../components/employer/OfferScopeForm';
import CategoryForm from '../../../components/employer/CategoryForm';
import { mapState, mapMutations } from 'vuex';

  export default {
    created(){ 
      this.$store.commit('EmployerOfferStore/setStep', 1);
    },
    components:{
      'offer-form':OfferForm,
      'offer-scope-form': OfferScopeForm,
      'category-form': CategoryForm
    },                
    computed: {
      ...mapState('EmployerOfferStore', ['step']), 
      ...mapState(['globalLoading']),     
      currentTitle () {
        switch (this.step) {
          case 1: return 'Información general'
          case 2: return 'Cobertura de la oferta'
          default: return 'Categorías de la oferta'
        }
      }      
    },
    methods:{
      ...mapMutations('EmployerOfferStore', ['setStep']),
      submitInfo(){
        this.$store.commit('EmployerOfferStore/setSubmttingForm', true)        
      },
      goBack(){
        this.$router.push({name:'employer.offers'});
      }
    }        
  }
</script>
