<template>
    <div id="offer-form">        
        <v-form>
          <v-container>
            <v-layout>              
              <v-flex class="mx-auto" sm3>
                <v-select
                  placeholder="Estado"
                  v-model="offer.visible"
                  :items="visibleOpts"
                  item-text="text"
                  item-value="id"
                  hint="Público/Privado"                
                >                      
                </v-select>
              </v-flex>
            </v-layout>  
            
            <v-layout>
              <v-flex sm12>
                <v-text-field
                  v-model="offer.vacancyName"
                  :error-messages="vacancyNameErrors"
                  label="Vacante"
                  :counter="100"
                  placeholder="Ej: Analista Contable, Ingeniero de sistemas"                  
                  @input="$v.offer.vacancyName.$touch()"
                  @blur="$v.offer.vacancyName.$touch()"
                  maxlength="100"
                >                  
                </v-text-field>
              </v-flex>              
            </v-layout>
            
            <v-layout>                            
              <v-flex xs12 sm6>
                <v-menu
                  v-model="menuStartDate"
                  :close-on-content-click="false"
                  :nudge-right="40"
                  lazy
                  transition="scale-transition"
                  offset-y
                  full-width
                  min-width="290px"                  
                >
                  <template v-slot:activator="{ on }">
                    <v-text-field
                      v-model="offer.publicationStart"
                      label="Inicio de publicación"
                      prepend-icon="event"
                      readonly
                      v-on="on"                      
                    ></v-text-field>
                  </template>
                  <v-date-picker locale="es-es"                     
                  v-model="offer.publicationStart" 
                  :min="today"
                  :error-messages="publicationStartErrors"
                  @input="menuStartDate = false"
                  @blur="$v.offer.publicationStart.$touch()"
                  ></v-date-picker>
                </v-menu>
              </v-flex>
              <v-flex>
                <v-menu
                  v-model="menuEndDate"
                  :close-on-content-click="false"
                  :nudge-right="40"
                  lazy
                  transition="scale-transition"
                  offset-y
                  full-width
                  min-width="290px"
                >
                  <template v-slot:activator="{ on }">
                    <v-text-field
                      v-model="offer.publicationEnd"
                      label="Fin de publicación"
                      prepend-icon="event"
                      readonly
                      v-on="on"
                    ></v-text-field>
                  </template>
                  <v-date-picker locale="es-es" v-model="offer.publicationEnd" 
                    @input="menuEndDate = false"
                    :min="offer.publicationStart" 
                    required                   
                  ></v-date-picker>
                </v-menu>
              </v-flex>            
            </v-layout>
            <v-layout>
              <v-flex sm4 xs12>                
                <v-select 
                  v-model="offer.contractType"
                  :items="contracts"
                  item-value="id"
                  item-text="text"
                  label="Tipo de contrato"
                  :error-messages="contractTypeErrors"                  
                  @input="$v.offer.contractType.$touch()"
                  @blur="$v.offer.contractType.$touch()"
                >
                </v-select>              
              </v-flex>
              <v-flex sm4 xs12>
                <v-text-field
                type="number"
                ref="salary"
                v-model="offer.salary"
                label="Salario"
                placeholder="Ej: 650000"
                :disabled="expand"
                :error-messages="salaryErrors"                  
                @input="$v.offer.salary.$touch()"
                @blur="$v.offer.salary.$touch()"
                >
                </v-text-field>
              </v-flex>
              <v-flex sm4 xs12>
                <v-switch color="indigo" v-model="expand" :label="(expand) ? 'Cambiar salario' : 'Por definir'"></v-switch>
              </v-flex>
            </v-layout>
            
            <v-layout>
              <v-flex sm4 xs12>
                <v-text-field                
                  v-model="offer.contactPhone"
                  label="Teléfono contacto de la oferta"
                  placeholder="Escriba un número local"  
                  :error-messages="contactPhoneErrors"                  
                  @input="$v.offer.contactPhone.$touch()"
                  @blur="$v.offer.contactPhone.$touch()"              
                >
                </v-text-field>
              </v-flex>

              <v-flex sm4 xs12>
                <v-text-field                
                  v-model="offer.contactCellPhone"
                  label="Celular contacto de la oferta"
                  placeholder="Escriba un número celular"               
                  :error-messages="contactCellPhoneErrors"                  
                  @input="$v.offer.contactCellPhone.$touch()"
                  @blur="$v.offer.contactCellPhone.$touch()"               
                >
                </v-text-field>
              </v-flex>

              <v-flex sm4 xs12>
                <v-text-field                
                  v-model="offer.contactEmail"
                  label="Email contacto de la oferta"
                  placeholder="recursos-humanos@...com" 
                  :error-messages="contactEmailErrors"                  
                  @input="$v.offer.contactEmail.$touch()"
                  @blur="$v.offer.contactEmail.$touch()"                              
                >
                </v-text-field>
              </v-flex>
            </v-layout>

            <v-layout>
              <v-flex>
                <v-textarea
                  v-model="offer.description"
                  label="Descripción de la oferta de trabajo"
                  :counter="1500"
                  :error-messages="descriptionErrors"                  
                  @input="$v.offer.description.$touch()"
                  @blur="$v.offer.description.$touch()" 
                  maxlength="1500"               
                >  
                </v-textarea>
              </v-flex>
            </v-layout>            
          </v-container>
          </v-form>
    </div>
</template>
<script>
const offerModel = {
  id:'', 
  vacancyName:'',
  description:'',
  publicationStart: new Date().toISOString().substr(0,10),
  publicationEnd: new Date().toISOString().substr(0,10),
  contractType:'',
  contactPhone:'',
  contactCellPhone:'',
  contactEmail:'',
  salary:'',
  visible:1   
};
import { validationMixin } from 'vuelidate';
import { required, minLength, maxLength, numeric,  maxValue, minValue, email} from 'vuelidate/lib/validators';
import { mapState, mapActions, mapGetters } from 'vuex';
export default {
  mixins: [validationMixin],   
  validations: {
    offer: {
      vacancyName: {required, minLength:minLength(10), maxLength:maxLength(100)}, 
      contractType: {required, numeric, maxValue:maxValue(4)},
      publicationStart:{ required },
      salary: {required, numeric, maxValue:maxValue(99999999)},
      contactPhone:{numeric, minLength:minLength(7), maxLength:maxLength(10)},
      contactCellPhone:{required, numeric, minLength:minLength(10), maxLength:maxLength(10)},
      contactEmail:{required, email, maxLength:maxLength(50)},
      description:{required, minLength:minLength(100), maxLength:maxLength(1500)}
    }
  },
  data: () => ({                
    offer: offerModel,    
    today:new Date().toISOString().substr(0,10),
    menuStartDate:false,
    menuEndDate:false,             
    expand: false    
  }),     
  mounted(){
    this.$store.commit('EmployerOfferStore/setOffer', '');
    if(this.$route.name == 'employer.offers.edit'){            
      this.editOffer(this.$route.params.id).then(res => {
        this.offer = res;       
        this.expand = res.salary == 0 ? true: false;         
      });      
    }     
  },
  methods:{
    ...mapActions('EmployerOfferStore',['storeOffer', 'editOffer']),
    submitForm(){       
      const startDate = new Date(this.offer.publicationStart);
      const endtDate = new Date(this.offer.publicationEnd);
      if(startDate.getTime() > endtDate.getTime()){
        alert('La fecha de inicio no puede ser superior a la fecha de finalización')
      }      
      this.$v.$touch();        
      if(!this.$v.$invalid){               
        this.storeOffer(this.offer);                      
      }
      //
    }
  },
  computed:{
    ...mapState('EmployerOfferStore', ['submittingForm', 'step', 'Offer']),
    ...mapGetters('EmployerOfferStore', ['contracts', 'visibleOpts']),
    vacancyNameErrors(){        
      const errors = []
      if (!this.$v.offer.vacancyName.$dirty) return errors
      !this.$v.offer.vacancyName.maxLength && errors.push('Excedió la cantidad de carácteres permitidos')
      !this.$v.offer.vacancyName.minLength && errors.push('Inserte mínimo 10 carácteres')
      !this.$v.offer.vacancyName.required && errors.push('Este campo es requerido!')
      return errors
    },
    publicationStartErrors(){
      const errors = []
      if (!this.$v.offer.publicationStart.$dirty) return errors      
      !this.$v.offer.publicationStart.required && errors.push('Este campo es requerido!')
      return errors
    },
    contractTypeErrors(){
      const errors = []
      if (!this.$v.offer.contractType.$dirty) return errors
      !this.$v.offer.contractType.maxValue && errors.push('Error en la opción seleccionada')
      !this.$v.offer.contractType.numeric && errors.push('Error en la opción seleccionada')
      !this.$v.offer.contractType.required && errors.push('Este campo es requerido!')
      return errors
    },
    salaryErrors(){
      const errors = []
      if (!this.$v.offer.salary.$dirty) return errors      
      !this.$v.offer.salary.maxValue && errors.push('Valor excedido!')
      !this.$v.offer.salary.required && errors.push('Valor requerido!')
      return errors
    },
    contactPhoneErrors(){
      const errors = []
      if (!this.$v.offer.contactPhone.$dirty) return errors      
      !this.$v.offer.contactPhone.minLength && errors.push('Ingrese mínimo 7 dígitos')
      !this.$v.offer.contactPhone.maxLength && errors.push('Ingrese máximo 10 dígitos')
      return errors
    },    
    contactCellPhoneErrors(){
      const errors = []
      if (!this.$v.offer.contactCellPhone.$dirty) return errors      
      !this.$v.offer.contactCellPhone.minLength && errors.push('Ingrese mínimo 10 dígitos')
      !this.$v.offer.contactCellPhone.maxLength && errors.push('Ingrese máximo 10 dígitos')
      !this.$v.offer.contactCellPhone.required && errors.push('Campo requerido!')
      return errors
    },
    contactEmailErrors(){
      const errors = []
      if (!this.$v.offer.contactEmail.$dirty) return errors            
      !this.$v.offer.contactEmail.maxLength && errors.push('Ingrese máximo 50 dígitos')
      !this.$v.offer.contactEmail.email && errors.push('Email inválido!')
      !this.$v.offer.contactEmail.required && errors.push('Campo requerido!')
      return errors
    },
    descriptionErrors(){
      const errors = []
      if (!this.$v.offer.description.$dirty) return errors            
      !this.$v.offer.description.minLength && errors.push('Ingrese mínimo 100 carácteres!')
      !this.$v.offer.description.maxLength && errors.push('Ingrese máximo 1500 carácteres')      
      !this.$v.offer.description.required && errors.push('Campo requerido!')
      return errors
    }      
  },  
  watch:{
    submittingForm(val){ 
      if(val === true && this.step == 1){                
        this.submitForm();
      }
      if(this.step == 1){
        this.$store.commit('EmployerOfferStore/setSubmttingForm', false)
      }      
    },
    /*Offer(val){         
      if(this.$route.name == 'employer.offers.edit'){        
        this.offer = Object.assign({}, val);
      } else {        
        this.offer = offerModel;
      } 
      
      if(val.salary == 0){
        this.expand = true;
      }      
            
    },*/
    expand(val){
      if(val === true){
        this.offer.salary = 0;
      } else {        
        setTimeout(() => {
          this.$refs.salary.focus();          
        },200);        
      }
    }     
  }  
}
</script>
