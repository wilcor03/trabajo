<template>
<div id="offer-show">  
  <v-layout row wrap>
    <v-flex xs12 sm6 offset-sm3>
      <v-card>

        <v-toolbar color="light-blue">
          <v-toolbar-side-icon @click="goBack()"><v-icon color="white">mdi-arrow-left</v-icon></v-toolbar-side-icon>
          <v-btn              
            color="pink"
            dark
            small
            absolute
            bottom
            right
            fab
            @click="edit()"
          >
            <v-icon>edit</v-icon>
          </v-btn>            
          <v-toolbar-title class="white--text">Detalles de la publicación</v-toolbar-title>
        </v-toolbar>

        <v-list two-line>
          <v-subheader>Información General</v-subheader>
          
          <v-list-tile avatar>
            <v-list-tile-content>
              <v-list-tile-title>Vacante</v-list-tile-title>
              <v-list-tile-sub-title>{{ Offer.vacancyName }}</v-list-tile-sub-title>
            </v-list-tile-content>
          </v-list-tile>
          <v-divider></v-divider>
          <v-list-tile avatar>
            <v-list-tile-content>
              <v-list-tile-title>Inicio de publicación</v-list-tile-title>
              <v-list-tile-sub-title>{{ Offer.publicationStart }}</v-list-tile-sub-title>
            </v-list-tile-content>
          </v-list-tile>
          <v-divider></v-divider>
          <v-list-tile avatar>
            <v-list-tile-content>
              <v-list-tile-title>Finalización de la publicación</v-list-tile-title>
              <v-list-tile-sub-title>{{ Offer.publicationEnd }}</v-list-tile-sub-title>
            </v-list-tile-content>
          </v-list-tile>
          <v-divider></v-divider>
          <v-list-tile avatar>
            <v-list-tile-content>
              <v-list-tile-title>Tipo de contrato</v-list-tile-title>
              <v-list-tile-sub-title>{{ contractTypeName.text }}</v-list-tile-sub-title>
            </v-list-tile-content>
          </v-list-tile>
          <v-divider></v-divider>
          <v-list-tile avatar>
            <v-list-tile-content>
              <v-list-tile-title>Salario de la oferta</v-list-tile-title>
              <v-list-tile-sub-title>{{ Offer.salary || 'Por definir' }}</v-list-tile-sub-title>
            </v-list-tile-content>
          </v-list-tile>
          <v-divider></v-divider>
          <v-list-tile avatar>
            <v-list-tile-content>
              <v-list-tile-title>Visible</v-list-tile-title>
              <v-list-tile-sub-title><span v-if="Offer.visible">Si</span><span v-else>No</span></v-list-tile-sub-title>
            </v-list-tile-content>
          </v-list-tile>
          
          <v-subheader v-if="Offer.coverage == 1 || Offer.coverage == 2">Cobertura</v-subheader>

          <template v-if="Offer.coverage == 2">
            <v-list-tile avatar v-if="Offer.cities[0] != undefined">
              <v-list-tile-content>
                <v-list-tile-title>Ciudades</v-list-tile-title>
                <v-list-tile-sub-title>
                  <v-chip color="primary" text-color="white" v-for="city in Offer.cities" :key="city.id">
                    {{ city.name }}
                  </v-chip>
                </v-list-tile-sub-title>
              </v-list-tile-content>
            </v-list-tile>

            <v-list-tile avatar v-if="Offer.departaments[0] != undefined">
              <v-list-tile-content>
                <v-list-tile-title>Departamentos</v-list-tile-title>
                <v-list-tile-sub-title>
                  <v-chip color="secondary" text-color="white" v-for="dep in Offer.departaments" :key="dep.id">
                    {{ dep.name }}
                  </v-chip>
                </v-list-tile-sub-title>
              </v-list-tile-content>
            </v-list-tile>
          </template>

          <template v-else>
              <v-list-tile avatar>
              <v-list-tile-content>                  
                <v-list-tile-sub-title>
                  <v-chip color="secondary" text-color="white">
                    A nivel nacional
                  </v-chip>
                </v-list-tile-sub-title>
              </v-list-tile-content>
            </v-list-tile>
          </template>
          
          <v-subheader v-if="Offer.categories && Offer.categories[0] != undefined">Categorías</v-subheader>
          <v-list-tile avatar v-if="Offer.categories && Offer.categories[0] != undefined">
              <v-list-tile-content>
                
                <v-list-tile-sub-title>
                  <v-chip color="green" text-color="white" v-for="cat in Offer.categories" :key="cat.id">
                    {{ cat.name }}
                  </v-chip>
                </v-list-tile-sub-title>
              </v-list-tile-content>
            </v-list-tile>

        </v-list>      
        
      </v-card>
    </v-flex>
    
  </v-layout>  
</div>
</template>
<script>
import { mapActions, mapState, mapGetters } from 'vuex';
export default {
  created(){    
    this.showOffer(this.$route.params.id);
  },
  methods:{
    ...mapActions('EmployerOfferStore', ['showOffer']),
    edit(){
      this.$router.push({name:'employer.offers.edit', params:{id:this.Offer.id}});
    },
    goBack(){
      this.$router.go(-1);
    }
  },
  computed:{
    ...mapState('EmployerOfferStore', ['Offer']),
    ...mapGetters('EmployerOfferStore', ['contracts']),
    contractTypeName(){
      const pos = this.contracts.findIndex(el => {
        return el.id == this.Offer.contractType
      });      
      return this.contracts[3];
    }
  }
}
</script>