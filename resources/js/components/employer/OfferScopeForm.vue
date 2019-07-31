<template>
  <div id="offer-scope">
    <form>
      <v-container>
        <p>
          En que lugares del país verán su anuncio?
        </p>
        <v-radio-group v-model="option" column
          :error-messages="optionErrors"                  
          @input="$v.option.$touch()"
          @blur="$v.option.$touch()"                
        >
          <v-radio label="A nivel Nacional" :value="1"></v-radio>
          <v-radio label="Solo algunas ciudades y/o departamentos" :value="2"></v-radio>
        </v-radio-group>        
        <template v-if="option == 2">
          <div>            
            <cities-and-deps :selecteds="selectedOptions" @citiesAndDeps="onCitiesAndDeps($event)"/>    
          </div>
          <span class="error--text">{{ error }}</span>
        </template>
        
      </v-container>
    </form>
  </div>
</template>
<script>
import { validationMixin } from 'vuelidate'
import { required } from 'vuelidate/lib/validators';
import CitiesAndDeps from '../CitiesAndDeps';
import { mapState, mapActions } from 'vuex';
export default {
  mixins: [validationMixin],   
  validations: {
    option: {required}
  },
  components:{
    'cities-and-deps': CitiesAndDeps
  },
  data:() => ({
    option: '',
    selectedOptions:[],
    error:''
  }),
  computed:{
    ...mapState('EmployerOfferStore',['submittingForm', 'step', 'Offer']),
    ...mapState('SettingsStore', ['citiesAndDeps']),
    optionErrors(){        
      const errors = []
      if (!this.$v.option.$dirty) return errors      
      !this.$v.option.required && errors.push('Este campo es requerido!')
      return errors
    },
  },
  methods:{
    submitForm(){  
      this.$v.$touch();  
      this.error = '';
      if(this.option == 2 && this.selectedOptions && !this.selectedOptions.length){
        this.error = 'Elija almenos una ciudad o departamento!';
        return false;
      }
      
      if(!this.$v.$invalid){        
        const offerID =  this.Offer.id; //2
        this.attachCitiesAndDeps({cityIDs:this.calcId('city'), depIDs:this.calcId('dep'), offerID: offerID, coverage:this.option});
      }
    },
    onCitiesAndDeps(selected){
      this.selectedOptions = selected;
    },
    ...mapActions('EmployerOfferStore', ['attachCitiesAndDeps']),
    calcId(type){
      let realIds = [];
      this.selectedOptions.map(uniqId => {
        const position = this.citiesAndDeps.findIndex(item => {
          return item.uniqId === uniqId && item.type == type;
        });
        if(position > -1){
          realIds.push(this.citiesAndDeps[position].id);
        }        
      })
      return realIds;
    },
    setCoverage(offer){      
      let ids = [];
      offer.departaments.map(item => {
        ids.push('dep'+ item.id);
      });

      offer.cities.map(item => {
        ids.push('city'+item.id);
      })
      return ids;
    }
  },
  created(){ 
    if(this.$route.name == 'employer.offers.edit'){         
      this.option = this.Offer.coverage;      
      this.selectedOptions = this.setCoverage(this.Offer);
    }
  },
  watch:{
    submittingForm(val){
      if(val === true && this.step === 2){
        this.submitForm()
      }
      if(this.step == 2){
        this.$store.commit('EmployerOfferStore/setSubmttingForm', false)
      }
    }
  }  
}
</script>
