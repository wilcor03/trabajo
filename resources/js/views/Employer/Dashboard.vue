<template>
<div id="base">
  <v-layout>
    <v-flex md6 class="text-md-right">
      <v-card   
      class="mr-auto"       
      color="#26c6da"
      dark
      max-width="400"
    >
      <v-card-title>
        <v-icon
          large
          left
        >
          mdi-office-building
        </v-icon>
        <span class="title font-weight-light yellow--text">
          <strong><u>Información de mi empresa</u></strong>
          </span>
      </v-card-title>

      <v-card-text class="headline font-weight-bold">
        <template v-if="!Profile">
          Ingresa los datos de tu empresa para que puedas publicar ofertas de trabajo.
        </template>
        <template v-else>
          El perfil de tu empresa esta creado, mantenlo actualizado por favor!
        </template>
      </v-card-text>

      <v-card-actions>
        <v-list-tile class="grow">
          <v-layout
            align-center
            justify-end
          >            
            <span class="subheading">
              <template v-if="Profile">                 
                <router-link :to="{name:'employer.profile'}">
                  <v-icon>arrow_forward</v-icon>
                </router-link>    
              </template>
              <template v-else>
                <router-link :to="{name:'employer.profile.add'}">
                  <v-icon>arrow_forward</v-icon>
                </router-link>  
              </template>
                          
            </span>
          </v-layout>
        </v-list-tile>
      </v-card-actions>
    </v-card>
    </v-flex>

    <v-flex md6>
      <v-card   
      class="mx-auto"       
      color="#26c6da"
      dark
      max-width="400"
    >
      <v-card-title>
        <v-icon
          large
          left
        >
          mdi-file-document-box-multiple-outline
        </v-icon>
        <span class="title font-weight-light yellow--text">
          <strong><u>Publicar ofertas de empleo</u></strong>
        </span>
      </v-card-title>

      <v-card-text class="headline font-weight-bold">
        <template v-if="!Profile">
          Actualiza los datos de tu empresa para que puedas publicar ofertas ilimitadas!
        </template>
        <template v-else>
          Perfecto, ya estas listo para que puedas publicar ofetas de empleo ilimitadas!
        </template>
      </v-card-text>

      <v-card-actions>
        <v-list-tile class="grow">
          <v-layout
            align-center
            justify-end
          >            
            <span class="subheading">
              <router-link v-if="Profile" :to="{name:'employer.offers'}">
                <v-icon>arrow_forward</v-icon>
              </router-link>
            </span>
          </v-layout>
        </v-list-tile>
      </v-card-actions>
    </v-card>
  </v-flex>
</v-layout>

</div>    
</template>
<script>
import {mapActions, mapState} from 'vuex';
export default {
  created(){
    this.getProfile();
  },
  methods:{
    ...mapActions('EmployerProfileStore', ['getProfile'])
  },
  computed:{
    ...mapState('EmployerProfileStore', ['Profile'])
  }
}
</script>