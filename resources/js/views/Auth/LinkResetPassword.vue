<template>
    <div id="link-reset-pass">
  <v-container>
    <v-form @submit.prevent="submit" v-model="valid" ref="form">
  <div
    id="e3"
    style="max-width: 400px; margin: auto;"
    class="grey lighten-3"
  >
    <v-toolbar
      color="cyan"
      dark
    >
      <v-toolbar-side-icon><v-icon>mdi-lock-reset</v-icon></v-toolbar-side-icon>
      <v-toolbar-title>Resetear contraseña</v-toolbar-title>      
    </v-toolbar>

    <v-card>
      <v-container
        fluid
        grid-list-lg
      >
        <v-layout row wrap v-if="!success">
          <v-flex xs12>
            <v-card>              
              <v-card-text ref="form">
                <v-text-field
                  v-model="email"                                        
                  label="E-mail"
                  :rules="emailRules"
                  required
                ></v-text-field>

              </v-card-text>
              <v-card-actions>
                <v-btn :loading="loading" :disabled="loading" type="submit" color="info" block>enviar</v-btn>
              </v-card-actions>
            </v-card>
          </v-flex>
        </v-layout>

        <v-layout row wrap v-if="success">
          <v-flex>
            <v-alert
              :value="true"
              type="success"
            >
              Exito!
            </v-alert>
            <p class="text-md-center">
              Hemos enviado un enlace a su correo para que pueda resetear su contraseña!
            </p>
          </v-flex>
        </v-layout>
      </v-container>
    </v-card>
  </div>
    </v-form>
  </v-container>
</div>
</template>
<script>
import Axios from 'axios';
export default {
    data:() => ({
        valid:true,
        email:'',
        loading:false,
        success:false,
        emailRules: [
          v => !!v || 'Campo requerido!',
          v => /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,4})+$/.test(v) || 'E-mail Inválido',
          v => (v && v.length <= 99) || 'Debe ser Menor a 100 caractéres!'
        ],
    }),
    methods:{
        submit(){  
          this.loading = true;                    
          if (!this.$refs.form.validate()) {      
            this.snackbar = true
            this.loading = false;
            return false;
          }  
          this.$store.dispatch('AuthStore/getLinkPassword', this.email).then(res => {
            if(res.status == 200){
              this.success = true;
            }
          }).finally(() => {
            this.loading = false;
          });
        }
    }
}
</script>