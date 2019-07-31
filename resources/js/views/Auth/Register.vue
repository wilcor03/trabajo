<template>
<div id="register">  
  <v-container>  
  <div
    id="e3"
    style="max-width: 400px; margin: auto;"
    class="grey lighten-3"
  >
    <v-toolbar
      color="cyan"
      dark
    >
      <v-toolbar-side-icon><v-icon>mdi-account-plus</v-icon></v-toolbar-side-icon>
      <v-toolbar-title>Registro de usuario</v-toolbar-title>    
      </v-toolbar>
    <v-card>
      <v-container
        fluid
        grid-list-lg
      >
        <v-layout row wrap>
          <v-flex xs12>
            <v-card>
              <v-form 
                ref="form"
                v-model="valid"
                lazy-validation
              >
              <v-card-title primary-title v-if="profileType">
                <div v-if="profileType == 2">
                  <div class="headline">Registro como EMPLEADOR</div>
                  <span class="grey--text">
                    Encuentre personas idóneas!
                  </span>
                </div>
                <div v-else>
                  <div class="headline">Registro como TRABAJADOR</div>
                  <span class="grey--text">Publique su hoja de vida y haga que buenas empresas lo contacten!</span>
                </div>
              </v-card-title>
              <v-card-text ref="form">                
                  <v-text-field
                    v-model="data.name"                    
                    label="Su nombre"
                    :rules="nameRules"
                    maxLength="100"                    
                    required
                  ></v-text-field>

                  <v-text-field
                    v-model="data.email"                                        
                    label="E-mail"
                    :rules="emailRules"
                    maxLength="100"
                    required
                  ></v-text-field>

                  <v-select
                    v-model="data.profileType"                    
                    :items="registerTypes"                    
                    label="Tipo de registro"                    
                    required
                    item-value="type"
                    item-text="value"
                    :rules="registerTypesRules"
                  ></v-select>
                  
                  <v-text-field
                    v-model="data.password"
                    :append-icon="showPass ? 'visibility' : 'visibility_off'"                    
                    :type="showPass ? 'text' : 'password'"
                    name="input-10-1"
                    label="Contraseña"
                    hint="Al menos 8 caracteres"
                    maxLength="100"
                    :counter="100"
                    :rules="passwordRules"
                    @click:append="showPass = !showPass"
                  ></v-text-field>

              </v-card-text>
              <v-card-actions>
                <v-btn color="info" @click="submitForm()" block>
                  Registrarme <v-icon right>mdi-account-plus</v-icon>
                </v-btn>
              </v-card-actions>
              </v-form>
            </v-card>
          </v-flex>
        </v-layout>

        <v-layout>
        <v-flex class="text-md-center">
          <facebook-login 
            v-show="!facebookIsConnected"
            class="button"
            appId="1554582124798835"
            @login="onLogin"
            @logout="onLogout"            
            @sdk-loaded="sdkLoaded"
            loginLabel = 'Ingresar con Facebook'
            logoutLabel= "Salir de Facebook?"
            >
          </facebook-login>
          <v-btn :loading="loading" v-if="facebookIsConnected" @click="loginWithButtonFacebook" dark color="indigo">
            <v-icon left>mdi-facebook</v-icon>
            Ingresar con Facebook
          </v-btn>
        </v-flex>
      </v-layout> 
      </v-container>
    </v-card>
  </div>
  
  </v-container>
</div>
</template>
<script>
import {mapActions, mapState } from 'vuex';
import facebookLogin from 'facebook-login-vuejs';
import facebookLoginMixin from '../../mixins/facebookLogin';
export default { 
  components:{
    facebookLogin
  },  
  mixins:[facebookLoginMixin],
  data:() => ({
    registerTypes:[{type:2, value:'Como EMPLEADOR'}, {type:3, value:'Como TRABAJADOR'}],    
    showPass:false,
    valid:true,
    loading:false,
    data:{
      name:'',
      email:'',
      profileType:2,      
      password:''
    },   
      //RULES
    nameRules:[
      v => !!v || 'Campo requerido!',
      v => (v && v.length <= 99) || 'Debe ser menor a 100 caractéres!',
      v => (v && v.length >= 10) || 'Debe ser Mayor a 8 caractéres!'
    ],
    emailRules: [
      v => !!v || 'Campo requerido!',
      v => /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,4})+$/.test(v) || 'E-mail Inválido',
      v => (v && v.length <= 99) || 'Debe ser Menor a 100 caractéres!'
    ],
    passwordRules:[
      v => !!v || 'Campo requerido!',
      v => (v && v.length >= 8) || 'Inserte por lo menos 8 caractéres!'
    ],
    registerTypesRules: [
      v => !!v || 'Campo requerido!',
      v => (v && v == 2 || v == 3) || 'Campo Inválido'
    ]
  }), 
  created(){         
    const param =  parseInt(this.$route.params.type);    
    this.profileType = param ? param : 0;   
    this.data.profileType = param;      
  },  
  methods:{
    submitForm()
    { 
      if (!this.$refs.form.validate()) {      
        this.snackbar = true
        return false;
      }      
      
      this.sendingData(this.data); 
    }, 
    ...mapActions('AuthStore', ['register', 'getFacebookData'])
  },
  computed:{
    ...mapState('AuthStore', ['facebookIsConnected'])
  }
}
</script>
