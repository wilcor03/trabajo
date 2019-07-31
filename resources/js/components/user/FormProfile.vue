<template>
<div id="form-profile">
  <v-form @submit.prevent="submit">
    <v-container>
      <v-layout>
        <v-flex
          xs12
          md6
        >
          <v-text-field              
            v-model="user.name"          
            label="Nombres(s) y Apellido(s)"
            :error-messages="nameErrors"
            :counter="100"      
            required
            @input="$v.user.name.$touch()"
            @blur="$v.user.name.$touch()"
          ></v-text-field>
        </v-flex>

        <v-flex
          xs12
          md6
        >
          <v-text-field   
            v-model="user.email"                   
            label="Email"
            required
            disabled
          ></v-text-field>
        </v-flex>        
      </v-layout>
      <v-layout>
        <v-flex
          xs12
              md6
            >
            <v-text-field    
              v-model="user.celPhone"          
              label="Número télefono o celular"
              :error-messages="celPhoneErrors" 
              placeholder="310 XXX XX XX - 650 XX XX"                
              required
              @input="$v.user.celPhone.$touch()"
              @blur="$v.user.celPhone.$touch()"
              ></v-text-field>              
            </v-flex>

          <v-flex xs12 md6>
            <v-dialog
              ref="dialog"
              v-model="modal"
              :return-value.sync="user.birthDay"
              persistent
              lazy              
              full-width
              width="290px"
              transition="scale-transition"
            >
            <template v-slot:activator="{ on }">
              <v-text-field
                v-model="user.birthDay"
                :error-messages="birthDayErrors"
                ref="picker"
                label="Fecha de nacimiento"
                prepend-icon="event"
                readonly
                v-on="on"
              ></v-text-field>
            </template>
            <v-date-picker 
                ref="picker"
                locale="es-es"
                v-model="user.birthDay"
                max="2005-12-31"
                min="1950-01-01"
                type="date"
              >
              <v-spacer></v-spacer>
              <v-btn flat color="primary" @click="modal = false">Cerrar</v-btn>
              <v-btn flat color="primary" @click="$refs.dialog.save(user.birthDay)">Aceptar</v-btn>
            </v-date-picker>
          </v-dialog>

        </v-flex>        
      </v-layout>          

      <v-layout>
        <v-flex>
          <v-autocomplete
            v-model="user.city_id"
            :items="citiesObj"
            :loading="citiesObj && citiesObj[0]==undefined"      
            chips
            clearable
            hide-details
            hide-selected
            item-text="name"
            item-value="id"
            label="Busque la CIUDAD principal de su residencia"      
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

      <v-layout row wrap>
        <v-flex xs12>
          <v-textarea
            v-model="user.description"            
            label="¿Como se describe como persona?"
            value=""
            hint="Descripción breve."
            :error-messages="descriptionErrors" 
            :counter="1000"
            @input="$v.user.description.$touch()"
            @blur="$v.user.description.$touch()"
          ></v-textarea>
        </v-flex>
      </v-layout>

    <v-btn      
      :loading="saving"
      :disabled="saving"
      color="primary"      
      type="submit"
    >
      Guardar <v-icon>save</v-icon>
      
      <template v-slot:loader>
        <span>Guardando...</span>
      </template>
    </v-btn>      

    <v-btn flat @click="$store.commit('ProfileStore/setEditingMode', false)">Cancelar</v-btn>        
    </v-container>
  </v-form>
</div>   
</template>
<script>
import { createNamespacedHelpers } from 'vuex';
const { mapState, mapActions, mapGetters } = createNamespacedHelpers('ProfileStore');

import { storeProfile } from '../../services/profile'

import { validationMixin } from 'vuelidate'
import { required, minLength, maxLength } from 'vuelidate/lib/validators';

export default {
    mixins: [validationMixin],
    validations: {
      user: {
        name: {required, minLength:minLength(10), maxLength:maxLength(100)},        
        email: {required},
        celPhone: {required, minLength:minLength(10), maxLength:maxLength(10)},
        birthDay: {required},
        description: {required, minLength:minLength(50), maxLength:maxLength(1000)}
      }
    },
    data: () => ({      
      menu: true,
      modal: false,
      user:{
        name:null,        
        email:'',
        city_id:'',
        celPhone:'',
        birthDay: '2005-12-31',//new Date().toISOString().substr(0, 10),
        description: ''
      }      
    }),
    created()
    { 
      if(this.Profile){
        this.user = Object.assign({}, this.profileGet);
      }       

      this.getCitiesWithDeps();
    },
    watch:{
      Profile(val){
        this.user = Object.assign({}, val);
      },
      modal (val) {
        val && setTimeout(() => (this.$refs.picker.activePicker = 'YEAR'))
      }
    },
    methods:
    {      
      ...mapActions(['saveProfile', 'getProfile']),
      getCitiesWithDeps(){
        this.$store.dispatch('SettingsStore/getCitiesWithDeps');
      },
      submit () {        
        this.$v.$touch();        
        if(!this.$v.$invalid){
          this.saveProfile(this.user);
        }
      },
    },
    computed:
    {
      ...mapState(['saving', 'Profile']),
      ...mapGetters(['profileGet']),
      citiesObj(){
        return this.cities.map(item => {
          const newName = item.name + ' - '+ item.departament_name.toUpperCase();
          return Object.assign({}, item, {name: newName});
        })      
      },
      cities(){
        return this.$store.state.SettingsStore.cities;
      },
      nameErrors () {
        const errors = []
        if (!this.$v.user.name.$dirty) return errors
        !this.$v.user.name.minLength && errors.push('Inserte mínimo 10 caractéres')
        !this.$v.user.name.maxLength && errors.push('Inserte máximo 100 caractéres')
        !this.$v.user.name.required && errors.push('Campo requerido!')
        return errors
      },
        celPhoneErrors () {
        const errors = []
        if (!this.$v.user.celPhone.$dirty) return errors        
        !this.$v.user.celPhone.required && errors.push('Campo requerido!')
        return errors
      },
        descriptionErrors () {
        const errors = []
        if (!this.$v.user.description.$dirty) return errors        
        !this.$v.user.description.required && errors.push('Campo requerido!')
        !this.$v.user.description.minLength && errors.push('Inserte mínimo 50 caractéres')
        !this.$v.user.description.maxLength && errors.push('Inserte máximo 1000 caractéres')
        return errors
      },
      birthDayErrors () {
        const errors = []
        if (!this.$v.user.birthDay.$dirty) return errors        
        !this.$v.user.birthDay.required && errors.push('Campo requerido!')
        return errors
      },      
    }    
}
</script>
