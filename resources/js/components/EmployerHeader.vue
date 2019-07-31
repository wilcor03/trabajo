<template>
<div id="toolbar">
  <v-toolbar dark color="primary">
    <v-toolbar-side-icon @click.stop="drawer = !drawer"></v-toolbar-side-icon>

    <v-toolbar-title class="white--text">Contabilizalo.com - Empleo </v-toolbar-title>

    <v-spacer></v-spacer>    
    <span class="text-uppercase" v-if="currentUser">{{ currentUser.name }}</span>
    <v-menu bottom left>
      <template v-slot:activator="{ on }">
        <v-btn
          dark
          icon
          v-on="on"
        >
          <v-icon>more_vert</v-icon>
        </v-btn>
      </template>

      <v-list>
        <v-list-tile @click="logout">
          <v-list-tile-title>Cerrar Sesión</v-list-tile-title>
        </v-list-tile>
      </v-list>
    </v-menu>   
  </v-toolbar>
  
  <template v-if="globalLoading">
    <v-progress-linear :indeterminate="true"></v-progress-linear>
  </template>  

  <v-navigation-drawer
      v-model="drawer"
      :mini-variant="mini"
      absolute
      dark
      temporary
    >
    <v-list class="pa-1">
      <v-list-tile v-if="mini" @click.stop="mini = !mini">
        <v-list-tile-action>
          <v-icon>chevron_right</v-icon>
        </v-list-tile-action>
      </v-list-tile>

      <v-list-tile avatar tag="div">
        <v-list-tile-content>
          <v-list-tile-title class="text-capitalize" v-if="currentUser">{{ currentUser.name }}</v-list-tile-title>
        </v-list-tile-content>

        <v-list-tile-action>
          <v-btn icon @click.stop="mini = !mini">
            <v-icon>chevron_left</v-icon>
          </v-btn>
        </v-list-tile-action>
      </v-list-tile>
    </v-list>

    <v-list class="pt-0" dense>
      <v-divider light></v-divider>

      <v-list-tile
        v-for="item in items"
        :key="item.title"
        @click="goTarget(item.route)"
      >
        <v-list-tile-action>
          <v-icon>{{ item.icon }}</v-icon>
        </v-list-tile-action>

        <v-list-tile-content>
          <v-list-tile-title>{{ item.title }}</v-list-tile-title>
        </v-list-tile-content>
      </v-list-tile>


      <v-list-group
        prepend-icon="account_circle"
        value="true"
      >
        <template v-slot:activator>
          <v-list-tile>
            <v-list-tile-title>Ofertas de Empleo</v-list-tile-title>
          </v-list-tile>
        </template>
        <v-list-tile
            @click="goTarget('employer.offers.add')"              
          >
          <v-list-tile-title>Crear oferta</v-list-tile-title>
          <v-list-tile-action>
            <v-icon>add</v-icon>
          </v-list-tile-action>
        </v-list-tile>

        <v-list-tile
            @click="goTarget('employer.offers')"              
          >
          <v-list-tile-title>Mis ofertas</v-list-tile-title>
          <v-list-tile-action>
            <v-icon>insert_drive_file</v-icon>
          </v-list-tile-action>
        </v-list-tile>  
      </v-list-group>     

    </v-list>
  </v-navigation-drawer>

</div>
</template>
<script>
import { mapState } from 'vuex';
export default {
  computed:{
    ...mapState(['globalLoading']),
    ...mapState('AuthStore',['currentUser']),
    ...mapState('EmployerProfileStore', ['Profile'])
  },
  data:() => ({
    drawer: null,
    mini: false,
    right: null,
    items: [
      { title: 'Inicio', icon: 'dashboard', route:'employer.dashboard' },
      { title: 'Perfil de la empresa', icon: 'question_answer', route:'employer.profile' }
    ]       
  }),
  methods:{
    goTarget(route){            
      this.$router.push({name:route});      
    },
    logout(){      
      this.$store.dispatch('AuthStore/logout');      
      this.$router.push({name:'auth.login'});
    }
  }
}
</script>

<style scope>
  .card--flex-toolbar {
    margin-top: -64px;
  }
</style>

