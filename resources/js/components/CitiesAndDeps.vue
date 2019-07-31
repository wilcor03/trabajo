<template>
  <div id="cities-and-deps">
    <v-flex>
      <v-autocomplete
        v-model="scopes"
        :items="citiesAndDepsOpts"
        :loading="citiesAndDepsOpts && citiesAndDepsOpts[0]==undefined"      
        chips
        clearable
        multiple
        hide-details
        hide-selected
        item-text="name"
        item-value="uniqId"
        label="Seleccione una o varias ciudades y/o departamentos"      
      >
        <template v-slot:no-data>
          <v-list-tile>
            <v-list-tile-title>
              Seleccione <strong>CIUDADES y/o DEPARTAMENTOS</strong> en donde aparecerá su publicación
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
            <span v-text="item.name" class="pr-2"></span>
            <v-icon
              small
              @click.prevent="removeItem(item.uniqId)"
            >close</v-icon>
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
  </div>
</template>
<script>
import { mapActions, mapGetters } from 'vuex';
export default {
  props:['selecteds'],
  data:()=>({
    scopes:''
  }),
  mounted(){
    if(this.selecteds[0] != undefined){
      this.scopes = this.selecteds      
    }    
    this.getCitiesAndDeps();
  },
  methods:{
    ...mapActions('SettingsStore', ['getCitiesAndDeps']),
    removeItem(item){

      const pos = this.scopes.findIndex(el => {
        return el == item;
      })
      
      if(pos > -1){
        this.scopes.splice(pos, 1);
      }
    }
  },
  computed:{
    ...mapGetters('SettingsStore', ['citiesAndDepsOpts'])
  },
  watch:{
    scopes(val){
      this.$emit('citiesAndDeps', this.scopes);
    }
  }
}
</script>
