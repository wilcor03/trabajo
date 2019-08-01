<template>
  <div id="profile">      
    <v-layout row wrap>
      <v-flex xs12 sm6 offset-sm3>
        <v-card>

          <v-toolbar color="light-blue">
            <v-toolbar-side-icon @click="goBack()"><v-icon color="white">mdi-arrow-left</v-icon></v-toolbar-side-icon>
            <v-btn
              @click="editProfile"
              color="pink"
              dark
              small
              absolute
              bottom
              right
              fab
            >
              <v-icon>edit</v-icon>
            </v-btn>            
            <v-toolbar-title class="white--text">Datos de mi empresa</v-toolbar-title>
          </v-toolbar>
          
          <v-card-text class="grey lighten-5">
            <div class="my-2">
              <v-btn small dark color="indigo" :to="{name:'employer.offers.add'}">
                <v-icon left>add</v-icon>
                Pubicar una oferta de trabajo
              </v-btn>
            </div>
            <v-list>
              <v-subheader>
                <strong>Información general </strong>
              </v-subheader>
              <v-list-tile>
                <v-list-tile-action>
                  <v-icon color="success">mdi-account-card-details</v-icon>
                </v-list-tile-action>                

                <v-list-tile-content>
                  <v-list-tile-title>Nombre / Razón social</v-list-tile-title>
                  <v-list-tile-sub-title>{{ Profile.socialReason }}</v-list-tile-sub-title>
                </v-list-tile-content>                
              </v-list-tile>

              <v-divider inset></v-divider>

              <v-list-tile v-if="Profile.docType">
                <v-list-tile-action>
                  <v-icon>mdi-file-document-box-outline</v-icon>
                </v-list-tile-action>

                <v-list-tile-content>
                  <v-list-tile-title>Tipo de documento</v-list-tile-title>
                  <v-list-tile-sub-title>{{ Profile.docType.name }}</v-list-tile-sub-title>
                </v-list-tile-content>
              </v-list-tile>

              <v-divider inset></v-divider>

              <v-list-tile>
                <v-list-tile-action>
                  <v-icon>mdi-numeric-9-plus-box-multiple-outline</v-icon>
                </v-list-tile-action>

                <v-list-tile-content>
                  <v-list-tile-title>Número de documento</v-list-tile-title>
                  <v-list-tile-sub-title>{{ Profile.doc }} <span v-if="Profile.dv">- {{ Profile.dv }}</span> </v-list-tile-sub-title>
                </v-list-tile-content>
              </v-list-tile>

              <v-divider inset></v-divider>

              <v-list-tile>
                <v-list-tile-action>
                  <v-icon>phone</v-icon>
                </v-list-tile-action>

                <v-list-tile-content>
                  <v-list-tile-title>Teléfono fijo</v-list-tile-title>
                  <v-list-tile-sub-title>{{ Profile.phone }}</v-list-tile-sub-title>
                </v-list-tile-content>
              </v-list-tile>

              <v-divider inset></v-divider>

              <v-list-tile>
                <v-list-tile-action>
                  <v-icon>mdi-cellphone-iphone</v-icon>
                </v-list-tile-action>

                <v-list-tile-content>
                  <v-list-tile-title>Número celular</v-list-tile-title>
                  <v-list-tile-sub-title>{{ Profile.celPhone }}</v-list-tile-sub-title>
                </v-list-tile-content>
              </v-list-tile>

              <v-divider inset></v-divider>


              <v-list-tile>
                <v-list-tile-action>
                  <v-icon color="info">mail</v-icon>
                </v-list-tile-action>

                <v-list-tile-content>
                  <v-list-tile-title>Email</v-list-tile-title>
                  <v-list-tile-sub-title>{{ Profile.email }}</v-list-tile-sub-title>
                </v-list-tile-content>
              </v-list-tile>

              <v-divider inset></v-divider>

              <v-list-tile v-if="Profile.city">
                <v-list-tile-action>
                  <v-icon color="yellow">location_on</v-icon>
                </v-list-tile-action>

                <v-list-tile-content>
                  <v-list-tile-title>Ciudad principal</v-list-tile-title>
                  <v-list-tile-sub-title>{{ Profile.city.name }} ({{ Profile.city.departament_name  }})</v-list-tile-sub-title>
                </v-list-tile-content>
              </v-list-tile>
            </v-list>   

            <v-divider inset></v-divider>

            <v-item-group multiple>   
              <v-subheader>Sectore(s) económico(s)</v-subheader>                   
              <v-item
                v-for="sector in Profile.sectors" :key="sector.id"
              >
                <v-chip>
                  {{sector.name}}
                </v-chip>
              </v-item>
            </v-item-group> 
          </v-card-text>
          
        </v-card>
      </v-flex>
      
    </v-layout>  
</div>
</template>
<script>
import { mapState, mapActions } from 'vuex';
export default {  
  computed:{
    ...mapState('EmployerProfileStore', ['Profile'])
  },
  methods:{
    editProfile(){
      this.$router.push({name:'employer.profile.edit'})
    },
    goBack(){
      this.$router.push({name:'employer.dashboard'});
    }
  }  
}
</script>
