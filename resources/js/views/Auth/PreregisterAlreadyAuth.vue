<template>
    <v-container>
    <v-layout row wrap>
      <v-flex xs12 sm6 offset-sm3>
        <v-card>
          <v-toolbar color="light-blue">
            <v-toolbar-side-icon><v-icon color="white">home</v-icon></v-toolbar-side-icon>        
            <v-toolbar-title class="white--text">Seleccione el tipo de registro</v-toolbar-title>
          </v-toolbar>

          <v-divider></v-divider>

          <v-card-actions>
            <v-layout>
              <v-flex xs12 md6 mr-1>
                <v-card>
                  <div class="pa-3 text-xs-center">                    
                    <div class="mb-3" height="128" contain>
                      <v-icon color="indigo" size="128">mdi-office-building</v-icon>
                    </div>                   

                    <h3 class="title font-weight-light mb-2">Publicar ofertas de empleo</h3>                    
                    <span class="caption grey--text">Empleadores</span>
                  </div>
                  <v-card-actions>
                    <v-btn block color="orange" @click="updateProfileType(2)">Registro como Empleador</v-btn>                    
                  </v-card-actions>
                </v-card>
              </v-flex>

              <v-flex xs12 md6>
                <v-card>
                  <div class="pa-3 text-xs-center">                    
                    <div class="mb-3" height="128" contain>
                      <v-icon color="purple" size="128">mdi-account-arrow-right-outline</v-icon>
                    </div>                   

                    <h3 class="title font-weight-light mb-2">Publicar mi hoja de vida online</h3>                    
                    <span class="caption grey--text">Trabajadores</span>
                  </div>
                  <v-card-actions>
                    <v-btn block color="orange" @click="updateProfileType(3)">Registro como Trabajador</v-btn>                    
                  </v-card-actions>
                </v-card>
              </v-flex>
            </v-layout>
          </v-card-actions>
        </v-card>
      </v-flex>
    </v-layout>
  </v-container>
</template>
<script>
import { getLocalUser, getHeaders } from '../../services/Auth';
import { mapActions } from 'vuex';
export default {
    beforeRouteEnter (to, from, next) {
        next(vm => {
            const localUser = getLocalUser().then(localUser => {
                if(localUser == null){
                    next({name:'auth.login'})
                }

                let headers = getHeaders();
                axios.post('/api/user/current-user', {}, headers).then(res => {
                    const dbUser = res.data;
                    if(dbUser.profileType == 2){
                        next({name:'employer.dashboard'});
                    } else if(dbUser.profileType == 3){
                        next({name:'gen.info'});
                    }  
                })

            });                    
        })
    },
    methods:{
        updateProfileType(profileType){
            this.updateProfileTypeField(profileType).then(res => {
                const userDB = res.data;
                getLocalUser().then(localUser => {
                    localUser.profileType = profileType;
                    localStorage.removeItem('local_user');
                    const userUpdated = JSON.stringify(localUser);
                    localStorage.setItem('local_user', userUpdated)

                    if(localUser.profileType == 2){
                        this.$router.push({name:'employer.dashboard'});
                    } else if(localUser.profileType == 3){
                        this.$router.push({name:'gen.info'});
                    }                
                });                
            });
        },
        ...mapActions('AuthStore',['updateProfileTypeField'])
    }
}
</script>
