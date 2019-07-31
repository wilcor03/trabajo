<template>
<div id="offers">      
  <v-layout row wrap>
    <v-flex xs12 sm6 offset-sm3>
      <v-card>

        <v-toolbar color="light-blue">
          <v-toolbar-side-icon @click="goBack()"><v-icon color="white">mdi-arrow-left</v-icon></v-toolbar-side-icon>
          <v-btn
            @click="addOffer"
            color="pink"
            dark
            small
            absolute
            bottom
            right
            fab
          >
            <v-icon>add</v-icon>
          </v-btn>            
          <v-toolbar-title class="white--text">Mis publicaciones</v-toolbar-title>
        </v-toolbar>
        <template v-if="loading">
          <v-progress-linear :indeterminate="true"></v-progress-linear>  
        </template>
        <template v-if="!data.data">
          <div pt-5>
            <p class="text-xs-center">No hay registros Actualmente!</p>
          </div>
        </template>
        <v-list two-line v-if="data.data">
          <v-subheader>Ofertas publicadas actualmente</v-subheader>
          <template v-for="(item, index) in data.data">
            <br> 
            <v-list-tile
              :key="item.id"
              avatar
              ripple                
            >            
              <v-list-tile-content>
                <v-list-tile-title @click.prevent="showDetail(item.id)">
                  <strong class="pointer text-truncate text-uppercase purple darken-2 text-xs-center px-2 py-3">
                    <span class="white--text">
                      <u>
                        {{ item.vacancyName }}
                      </u>
                    </span></strong>
                </v-list-tile-title>
                <v-list-tile-sub-title class="text--primary">{{ item.description }}</v-list-tile-sub-title>
                <v-list-tile-sub-title>
                  <v-layout>
                    <v-flex md6>
                      Publicado: {{ item.updated_at }}
                    </v-flex>
                    <v-flex md2>
                      Público: 
                      <span v-if="item.visible == 1" class="success--text">SI</span>
                      <span v-else-if="item.visible == 0" class="red--text">NO</span>
                    </v-flex>
                    <v-flex md4>
                      Estado: 
                      <template v-if="item.isComplete">
                        <span v-if="item.state == null" class="info--text">En estudio</span>
                        <span v-else-if="item.state == 1" class="success--text">Aprobado</span>
                        <span v-else-if="item.state == 2" class="red--text">Denegado</span>
                      </template>
                      <template v-else>
                        <span class="red--text">INCOMPLETO</span>
                      </template>                      
                    </v-flex>                    
                  </v-layout>                                    
                </v-list-tile-sub-title>
              </v-list-tile-content>

              <v-list-tile-action>
                <v-list-tile-action-text>                  
                  <v-btn flat icon color="blue darken-2" @click="editOffer(item.id)">
                    <v-icon small>mdi-pencil</v-icon>
                  </v-btn>                  
                </v-list-tile-action-text>
                
                <v-btn flat icon color="red darken-2" @click="deleteItem(item.id)">
                  <v-icon>
                    mdi-delete-circle
                  </v-icon>
                </v-btn>
              </v-list-tile-action>

            </v-list-tile>
            <v-divider
              v-if="index + 1 < offers.length"
              :key="index"
            ></v-divider>
          </template>
        </v-list>              
      </v-card>
    </v-flex>
    
  </v-layout>
  
  <v-layout v-if="data.meta && data.meta != '' && data.data && data.meta.last_page > 1">
    <v-flex>
      <div class="text-xs-center">
        <v-pagination
          v-model="data.meta.current_page"
          :length="data.meta.last_page"
          circle
          @input="pagin($event)"
          :total-visible="7"  
          :disabled="loading"          
        ></v-pagination>
      </div>
    </v-flex>
  </v-layout>  
</div>
</template>
<script>
import { mapActions, mapState, mapGetters } from 'vuex';
export default {
  methods:{
    addOffer(){
      this.$store.commit('EmployerOfferStore/setOffer', '');
      this.$router.push({name:'employer.offers.add'});
    },
    showDetail(item_id){
      this.$router.push({name:'employer.offers.show', params:{id:item_id}});
    },    
    ...mapActions('EmployerOfferStore', ['list', 'deleteOffer']),    
    pagin(current_page){
      this.list(this.data.meta.path+'?page='+current_page);
    },
    goBack(){
      this.$router.push({name:'employer.dashboard'});
    },
    editOffer(id){
      this.$router.push({name:'employer.offers.edit', params:{id:id}});
    },
    deleteItem(id){
      if(confirm('Seguro que desea eliminar este item?')){
        this.deleteOffer(id);
      }
    }
  },
  computed:{
    ...mapState('EmployerOfferStore', ['offers', 'data', 'loading']),
    ...mapState(['globalLoading'])    
  },
  created(){        
    this.list();
  }  
}
</script>
<style scope>
  .pointer{
    cursor:pointer;
  }
</style>