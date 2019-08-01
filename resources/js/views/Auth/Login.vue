<template>
<div id="login">
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
      <v-toolbar-side-icon><v-icon>mdi-account-box</v-icon></v-toolbar-side-icon>
      <v-toolbar-title>Ingresar</v-toolbar-title>      
    </v-toolbar>    
    <v-card>
      <v-container
        fluid
        grid-list-lg
      >      
        <v-layout row wrap>
          <v-flex xs12>
            <v-form @submit.prevent="submit"
              ref="form"
              v-model="valid"
              lazy-validation
            >
            <v-card>              
              <v-card-title primary-title>
                <span class="grey--text">Ingresar a mi cuenta</span>                
              </v-card-title>              
              <v-card-text ref="form">
                <p v-if="credentialsInvalid" class="error--text">Usuario o Contraseña Inválidos!</p>
                <v-text-field
                  v-model="user.email"                                        
                  label="E-mail"
                  :rules="emailRules"                  
                  required
                ></v-text-field>

                <v-text-field
                  v-model="user.password"
                  :append-icon="showPass ? 'visibility' : 'visibility_off'"                    
                  :type="showPass ? 'text' : 'password'"                  
                  label="Contraseña"
                  :rules="passwordRules"                                    
                  @click:append="showPass = !showPass"
                ></v-text-field>

              </v-card-text>
              <v-card-actions>
                <v-btn type="submit" :loading="loading" :disabled="loading" color="info" block
                
                >Ingresar <v-icon right>mdi-login-variant</v-icon> </v-btn>                                                
              </v-card-actions>
              
            </v-card>
            </v-form>
            <br>
            <router-link :to="{name:'auth.link-reset-pass'}">Olvido su contraseña?</router-link> 
            <br>
            <router-link :to="{name:'auth.register'}">Crear una cuenta?</router-link>             
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
          <v-btn :loading="loading" :disabled="loading" v-if="facebookIsConnected" @click="loginWithButtonFacebook" dark color="indigo">
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
import { mapActions, mapState } from 'vuex';
import CategoryListVue from '../categories/CategoryList.vue';
import facebookLogin from 'facebook-login-vuejs';
import facebookLoginMixin from '../../mixins/facebookLogin';
export default { 
  components:{
    facebookLogin
  },   
  data:() => ({   
    valid: true,
    loading:false,
    user:{      
      email:'',    
      password:''      
    },    
    emailRules: [
      v => !!v || 'Campo requerido!',
    ],       
    passwordRules: [
      v => !!v || 'Campo requerido!',
    ],
    showPass:false,
    credentialsInvalid:false
  }),      
  computed:{
    ...mapState('AuthStore', ['facebookIsConnected'])    
  },
  mixins:[facebookLoginMixin],
  methods:{    
    ...mapActions('AuthStore', ['login', 'register', 'getFacebookData']),
    submit(){
      if (this.$refs.form.validate()) {    
        this.loading = true;    
        this.snackbar = true;
        this.login(this.user).then(localUser => {
          if(localUser){
            if(localUser.profileType == 2){//trabajador
              this.$router.push({name:'employer.dashboard'});
            } else if(localUser.profileType == 3){  
              this.$router.push({name:'gen.info'});
            }
          }
        }).catch(err => {
          this.credentialsInvalid = true;
          setTimeout(() => {
            this.credentialsInvalid = false;
          }, 4000);          
        }).finally(() => {
          this.loading = false;
        })
      }      
    }
  }  
}
</script>
