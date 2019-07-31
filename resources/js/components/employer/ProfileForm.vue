<template>
<div id="profile-form"> 
  <v-form 
    @submit.prevent="submit(profile)"
    ref="form"    
    lazy-validation
  >
  <v-layout wrap>
    <v-flex      
      md6
    >
      <v-text-field                
        v-model="profile.socialReason"
        label="Razón social / Nombre"
        :error-messages="socialReasonErrors"
        :counter="100"
        @input="$v.profile.socialReason.$touch()"
        @blur="$v.profile.socialReason.$touch()"
      ></v-text-field>
    </v-flex>

    <v-flex md6>
        <v-select
          v-model="profile.docType"
          :items="docTypes"
          :loading="docTypes[0] == undefined"
          item-text="name"
          item-value="id"
          label="Tipo de documento"          
          :error-messages="docTypeErrors"        
          @input="$v.profile.docType.$touch()"
          @blur="$v.profile.docType.$touch()"
        ></v-select>
      </v-flex>      
  </v-layout>

  <v-layout wrap>
    <v-flex      
      xs10 md6
    >
      <v-text-field               
        v-model="profile.doc"
        label="Número de documento"
        :error-messages="docErrors"        
        @input="$v.profile.doc.$touch()"
        @blur="$v.profile.doc.$touch()" 
      ></v-text-field>
    </v-flex>
  
    <v-flex      
      xs2 md1
    >
      <v-text-field             
        type="number"
        v-model="profile.dv"
        label="DV"
        min="0"
        max="99"
        :error-messages="dvErrors"        
        @input="$v.profile.dv.$touch()"
        @blur="$v.profile.dv.$touch()"      
      ></v-text-field>
    </v-flex>

    <v-flex xs12 md5>
        <v-text-field        
        type="number"        
        v-model="profile.phone"
        label="Teléfono fijo"
        :error-messages="phoneErrors"        
        @input="$v.profile.phone.$touch()"
        @blur="$v.profile.phone.$touch()"        
      ></v-text-field>
    </v-flex>
  </v-layout>


  <v-layout wrap>
    <v-flex      
      md6
    >
      <v-text-field     
        type="number"   
        v-model="profile.celPhone"
        label="Teléfono celular"
        :error-messages="celPhoneErrors"        
        @input="$v.profile.celPhone.$touch()"
        @blur="$v.profile.celPhone.$touch()"            
      ></v-text-field>
    </v-flex>

    <v-flex md6>
      <v-text-field        
        type="email"
        v-model="profile.email"
        label="Email empresarial"
        :error-messages="emailErrors"        
        @input="$v.profile.email.$touch()"
        @blur="$v.profile.email.$touch()"
      ></v-text-field>
    </v-flex>
  </v-layout>

  <v-layout>
    <v-flex>
      <v-autocomplete
        v-model="profile.city_id"
        :items="citiesObj"
        :loading="citiesObj && citiesObj[0]==undefined"      
        chips
        clearable
        hide-details
        hide-selected
        item-text="name"
        item-value="id"
        label="Busque la CIUDAD principal de su empresa"  
        :error-messages="cityErrors"        
        @input="$v.profile.city_id.$touch()"
        @blur="$v.profile.city_id.$touch()"    
      >
        <template v-slot:no-data>
          <v-list-tile>
            <v-list-tile-title>
              Encuentre la <strong>CIUDAD</strong> principal de su empresa            
            </v-list-tile-title>
          </v-list-tile>
        </template>
        <template v-slot:selection="{ item, selected }">
          <v-chip
            :selected="selected"
            color="blue-grey"
            class="white--text"
          >
            <v-icon left>mdi-check</v-icon>
            <span v-text="item.name"></span>
          </v-chip>
        </template>
        <template v-slot:item="{ item }">
          <v-list-tile-avatar
            color="indigo"
            class="headline font-weight-light white--text"
          >
            {{ item.name.charAt(0) }}
          </v-list-tile-avatar>
          <v-list-tile-content>
            <v-list-tile-title v-text="item.name"></v-list-tile-title>
            <v-list-tile-sub-title v-text="item.departament_name"></v-list-tile-sub-title>
          </v-list-tile-content>
          <v-list-tile-action>
            <v-icon color="orange">mdi-map-marker</v-icon>
          </v-list-tile-action>
        </template>
      </v-autocomplete>

    </v-flex>
  </v-layout>

  <v-layout>  
    <v-flex>    
      <v-select
        v-model="profile.sectors"
        :items="sectorList"
        item-text="name"
        item-value="id"
        attach
        chips
        label="Seleccione el sector o sectores de su empresa"
        multiple
        :error-messages="sectorsErrors"        
        @input="$v.profile.sectors.$touch()"
        @blur="$v.profile.sectors.$touch()" 
      ></v-select>

    </v-flex>
  </v-layout> 
    <template>
      <v-btn 
      :disabled="globalLoading" 
      :loading="globalLoading"
      block 
      color="info" 
      type="submit"       
      >Guardar <v-icon right dark>mdi-content-save-all</v-icon></v-btn>
    </template>
  </v-form>  
</div>
</template>
<script>
import { validationMixin } from 'vuelidate';
import { required, minLength, maxLength, maxValue, minValue, numeric, email } from 'vuelidate/lib/validators';
import { mapActions, mapState, mapGetters } from 'vuex';

export default {
  mixins: [validationMixin],
  validations: {
    profile: {
      socialReason: {required, minLength:minLength(3), maxLength:maxLength(100)},     
      docType: {required, maxValue:4, numeric},
      doc: { required, numeric, minLength:minLength(4), maxLength:maxLength(15) },
      dv: { numeric, minValue:0, maxValue:99, minLength:minLength(1), maxLength:maxLength(2) },
      phone: { numeric, minLength:minLength(7), maxLength:maxLength(10) },
      celPhone: { numeric, minLength:minLength(10), maxLength:maxLength(10) },
      email: { required, email, minLength:minLength(3), maxLength:maxLength(50) },
      city_id: { required, numeric },
      sectors: { required }
    }
  },
  data: () => ({
    profile:{
      id:'',
      socialReason: '',
      docType: '',
      doc: '',
      dv: '',
      phone: '',
      celPhone: '',
      email: '',
      city_id: '',
      sectors:[]
    },
    isLoading: false,
    items: [],
    model: null,
    search: null
  }),
  created(){    
    if(this.profileForm != false){
      this.profile = Object.assign({}, this.profileForm);    
    }            
    this.getDocTypes();
    this.getCitiesWithDeps();   
    this.getSectors();
  },
  methods:{
    submit () {        
      this.$v.$touch();        
      if(!this.$v.$invalid){
        this.storeProfile(this.profile);
      }
    },
    ...mapActions('SettingsStore', ['getCitiesWithDeps', 'getDocTypes', 'getSectors']),
    ...mapActions('EmployerProfileStore', ['storeProfile'])    
  },
  computed:{    
    ...mapState('SettingsStore', ['docTypes', 'cities', 'sectorList']),
    ...mapState(['globalLoading']),
    ...mapState('EmployerProfileStore', ['saved']),
    ...mapGetters('EmployerProfileStore', ['profileForm']),
    citiesObj(){
      return this.cities.map(item => {
        const newName = item.name + ' - '+ item.departament_name.toUpperCase();
        return Object.assign({}, item, {name: newName});
      })      
    },
    socialReasonErrors(){
      const errors = []
      if (!this.$v.profile.socialReason.$dirty) return errors
      !this.$v.profile.socialReason.minLength && errors.push('Inserte mínimo 10 caractéres')
      !this.$v.profile.socialReason.maxLength && errors.push('Inserte máximo 100 caractéres')
      !this.$v.profile.socialReason.required && errors.push('Campo requerido!')
      return errors
    },
    docTypeErrors(){
      const errors = []
      if (!this.$v.profile.docType.$dirty) return errors
      !this.$v.profile.docType.maxValue && errors.push('Error!')      
      !this.$v.profile.docType.required && errors.push('Campo requerido!')
      return errors
    },    
    docErrors(){
      const errors = []
      if (!this.$v.profile.doc.$dirty) return errors
      !this.$v.profile.doc.minLength && errors.push('Inserte mínimo 4 caractéres')
      !this.$v.profile.doc.maxLength && errors.push('Inserte máximo 15 caractéres')
      !this.$v.profile.doc.required && errors.push('Campo requerido!')
      !this.$v.profile.doc.numeric && errors.push('Introduzca solo números!')
      return errors
    },
    dvErrors(){
      const errors = []
      if (!this.$v.profile.dv.$dirty) return errors
      !this.$v.profile.dv.minLength && errors.push('Inserte mínimo 1 caractéres')
      !this.$v.profile.dv.maxLength && errors.push('Inserte máximo 2 caractéres')
      !this.$v.profile.dv.minValue && errors.push('No inserte valores negativos')      
      !this.$v.profile.dv.numeric && errors.push('Introduzca solo números!')
      return errors
    },
    phoneErrors(){
      const errors = []
      if (!this.$v.profile.phone.$dirty) return errors
      !this.$v.profile.phone.minLength && errors.push('Inserte mínimo 7 caractéres')
      !this.$v.profile.phone.maxLength && errors.push('Inserte máximo 10 caractéres')      
      !this.$v.profile.phone.numeric && errors.push('Introduzca solo números!')
      return errors
    },
    celPhoneErrors(){
      const errors = []
      if (!this.$v.profile.celPhone.$dirty) return errors
      !this.$v.profile.celPhone.minLength && errors.push('Inserte mínimo 10 caractéres')
      !this.$v.profile.celPhone.maxLength && errors.push('Inserte máximo 10 caractéres')      
      !this.$v.profile.celPhone.numeric && errors.push('Introduzca solo números!')
      return errors
    },
    emailErrors(){
      const errors = []
      if (!this.$v.profile.email.$dirty) return errors
      !this.$v.profile.email.minLength && errors.push('Inserte mínimo 3 caractéres')
      !this.$v.profile.email.maxLength && errors.push('Inserte máximo 50 caractéres')      
      !this.$v.profile.email.email && errors.push('Email inválido!')
      !this.$v.profile.email.required && errors.push('Campo requerido!')
      return errors
    },
    cityErrors(){
      const errors = []
      if (!this.$v.profile.city_id.$dirty) return errors
      !this.$v.profile.city_id.numeric && errors.push('Error en campo!')      
      !this.$v.profile.city_id.required && errors.push('Campo requerido!')
      return errors
    },
    sectorsErrors(){
      const errors = []
      if (!this.$v.profile.sectors.$dirty) return errors          
      !this.$v.profile.sectors.required && errors.push('Campo requerido!')
      return errors
    }
  },
  watch:{
    saved(val){      
      if(val){
        this.$router.push({name:'employer.profile'});
      }
    }
  }

}
</script>